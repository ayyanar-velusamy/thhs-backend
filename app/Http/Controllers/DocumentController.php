<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UploadDocumentRequest;

use App\Models\User; 
use App\Models\ChartPosition; 
use App\Models\Position; 
use App\Models\Chart; 
use App\Models\Interval; 
use App\Models\Handling; 
use App\Models\ChartCategory; 
use App\Models\Document; 





class DocumentController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function hr(Request $request, $id)
    { 
        $charts = $this->getChartInformationData($id);  
        // pr($charts->toArray(),1);
        return view('staffs/hr', compact("charts"));
    }

    public function getChartInformationData($id)
    {  
        $user = User::findOrFail($id); 
        $data =  Position::where(['id' => $user->position])->with('charts')->first();
        $arr = array();
        foreach ($data->charts as  $key => $chart) {
            $valid_interval = Interval::where("id", $chart->valid_interval)->first()->name;
            @$renewal_interval = @Interval::where("id", $chart->renewal_interval)->first()->name;
            @$provide_interval = @Interval::where("id", $chart->provide_interval)->first()->name;
            $chart_handling = Handling::where("id", $chart->chart_handling)->first()->name;
            $category = ChartCategory::where("id", $chart->group)->first()->name; 
            $document = @Document::where(["user_id"=>$id,"chart_id" => $chart->id,"is_deleted" => "0"])->orderBy('id', 'DESC')->first();  
            
            $chart->valid_interval = $valid_interval;
            $chart->renewal_interval = @$renewal_interval;
            $chart->provide_interval = @$provide_interval;
            $chart->chart_handling = $chart_handling;
            $chart->category = $category;  
            $chart->document = $document;  
            $arr[$chart->category][$key] = $chart->toArray(); 
        }
        $data->category_chart = $arr;
        // pr($data, 1);
        // pr($chart_list->toArray(), 1);
        // exit;

        return $data;
    }
    public function upload_document(UploadDocumentRequest $request)
    {  
        if($this->delete_existing_documents($request)){

        
            $document = new Document(); 

            $document->chart_id = $request->input('chart_id');
            $document->document_path =  $this->upload_resume($request);
            $document->user_id =  $request->input('user_id');
            $document->issue_date =  @$this->getDocumetDetails(["user_id"=>$request->input('user_id'),"chart_id"=>$request->input('chart_id')])->issue_date;
            $document->renewal_date =  @$this->getDocumetDetails(["user_id"=>$request->input('user_id'),"chart_id"=>$request->input('chart_id')])->renewal_date;
            $document->created_by = $request->user()->id;
            // exit;
            if ($document->save()) {   
                $this->response['status'] = true;
                $this->response['message'] = "Document uploaded successfully"; 
                $this->response['document'] = $document; 
            } else {
                $this->response['status'] = false;
                $this->response['message'] = "Document uploading failed";
            }
            return $this->response();
        }
    }

    public function delete_existing_documents(Request $request){
        $user_id = $request->input('user_id');
        $chart_id = $request->input('chart_id');
        $documents = $this->getAllDocumetDetails(["user_id"=>$user_id,"chart_id"=>$chart_id]);
        // pr($documents->toArray(),1);
        if($documents){
            foreach($documents as $document){
                $request->request->add(["document_id"=>$document['id']]);
                $delete_document = $this->delete_document($request);
            }
            
            
        }
        return true;
    }



    public function getDocumetDetails($where){
        $document = Document::where($where)->first();
        return $document;
    }

    public function getAllDocumetDetails($where){
        $documents = Document::where($where)->get();
        return $documents;
    }
    

    private function upload_resume($request){ 
        $file = $request->file('document');  
        //Move Uploaded File
        $destinationPath = 'uploads/document/';
        $file->move($destinationPath,time()."_".$file->getClientOriginalName());   
       return $destinationPath.time()."_".$file->getClientOriginalName();
    }


    public function update_details(Request $request){ 
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        
        $document = Document::where(["user_id"=>$user_id,"chart_id"=>$id,"is_deleted"=>0])->first();
        // pr($document,1);
        if($document){
            $document->user_id =  $request->input('user_id');
            $document->issue_date =  @update_date_format($request->input('issue_date'), "Y-m-d");
            $document->is_verified =  (!$request->input('is_verified')?0:1);
            $document->renewal_date = @update_date_format($this->get_document_renewal_date($document->chart_id,$document->issue_date), "Y-m-d");
            
            if ($document->save()) {   
                $this->response['status'] = true;
                $this->response['message'] = "Document issue date updated successfully"; 
            } else {
                $this->response['status'] = false;
                $this->response['message'] = "Document issue date update failed";
            }
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "No Document added yet";
        }
        
        return $this->response();
    }


    private function get_document_renewal_date($id,$issue_date){
        $chart = Chart::find($id);
        // pr($chart);
        return get_document_renewal_date($chart->valid_interval, $chart->valid_number,$issue_date);
        
        
    }

    public function delete_document(Request $request){ 
        $id = $request->input('document_id');
        $document = Document::find($id);
        if($document){
            $document->is_deleted =  1;
            
            if ($document->save()) {   
                $this->response['status'] = true;
                $this->response['message'] = "Document deleted successfully"; 
            } else {
                $this->response['status'] = false;
                $this->response['message'] = "Document deletion failed";
            }
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "No Document added yet";
        }
        
        return $this->response();
    }
    
    public function get_deleted_documents(Request $request){
        $user_id = $request->input('user_id');
        $chart_id = $request->input('chart_id');
        $deleted_documents = $this->getAllDocumetDetails(["user_id"=>$user_id,"chart_id"=>$chart_id,"is_deleted"=>1 ]);
        $data = $deleted_documents->toArray();
        $this->response['status'] = false;
        $this->response['data'] = $data;
        return $this->response();

    }

}
