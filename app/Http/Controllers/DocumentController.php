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
            $document = @Document::where("chart_id", $chart->id)->orderBy('id', 'DESC')->first()->document_path;  

            $chart->valid_interval = $valid_interval;
            $chart->renewal_interval = @$renewal_interval;
            $chart->provide_interval = @$provide_interval;
            $chart->chart_handling = $chart_handling;
            $chart->category = $category;  
            $chart->document = $document;  
            $arr[$chart->category][$key] = $chart->toArray(); 
        }
        $data->category_chart = $arr;
        // pr($arr, 1);
        // pr($chart_list->toArray(), 1);
        // exit;

        return $data;
    }
    public function upload_document(UploadDocumentRequest $request)
    {  
            $document = new Document(); 
            $document->chart_id = $request->input('chart_id');
            $document->document_path =  $this->upload_resume($request);
            // exit;
            if ($document->save()) {   
                $this->response['status'] = true;
                $this->response['message'] = "Document uploaded successfully"; 
            } else {
                $this->response['status'] = false;
                $this->response['message'] = "Document uploading failed";
            }
            return $this->response();
    }

    private function upload_resume($request){ 
        $file = $request->file('document');  
        //Move Uploaded File
        $destinationPath = 'uploads/document/';
        $file->move($destinationPath,time()."_".$file->getClientOriginalName());   
       return $destinationPath.time()."_".$file->getClientOriginalName();
    }
    
}
