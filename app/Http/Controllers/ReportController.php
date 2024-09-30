<?php

namespace App\Http\Controllers; 
 
use App\Http\Requests\SaveReportRequest; 
use App\Models\Chart;
use App\Models\Report;
use App\Models\ChartCategory; 
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      
        $categories = ChartCategory::all();  
        $report = new Report(); 
        foreach ($categories as $category) {
            $reports = @Report::where("category_id", $category->id)->get();  
            // pr($reports,1);
            foreach ($reports as $report) {
                $report->report_exist = $this->reportExist($report->report_id);
            }
           
            $category->reports = $reports;  
           
        }  
      
        return view('reports/report', compact("categories"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    
 
    public function designer(Request $request)
    { 
        $report_data['id'] = $request->query('reportId');
        $report_data['report_exist'] = $this->reportExist($report_data['id']);
 
        return view('designer', compact("report_data"));
     
    }  

    public function viewer(Request $request)
    { 
        $report_data['id'] = $request->query('reportId');
        $report_data['report_exist'] = $this->reportExist($report_data['id']); 
        return view('viewer', compact("report_data"));
     
    }  

    public function export(Request $request)
    { 
        $report_data['id'] = $request->query('reportId'); 
        $report_data['report_exist'] = $this->reportExist($report_data['id']); 
        return view('export', compact("report_data"));
     
    }  

    public function save_report(SaveReportRequest $request)
    { 
        $report = new Report(); 

        $report_id = $request->input('id');
        if ( $report_id) {
            $report = Report::find( $report_id);
        } 
        $report->name = $request->input('name');  
        $report->report_id = time(); 
        $report->category_id = $request->input('category');  
        $report->created_by = $request->user()->id;
        if ($report->save()) {
            $this->response['status'] = true;
            $this->response['message'] = "Report saved successfully";
        } else {
            $this->response['status'] = false;
            $this->response['message'] = "Report saving failed";
        }
        return $this->response();
    } 

    public function get_report(Request $request, $id)
    {
        $data = $this->getReportInfoData($id);
        // pr($id,1);
        $this->response = compact("data");
        return $this->response();
    }

    public function getReportInfoData($id)
    {
        $report = Report::findOrFail($id);   
        // pr($chart,1);
        return ["report" => $report];
    }

    public function reportExist($id)
    {
        if(file_exists(public_path('reports/' . $id . '.mrt'))){
            return true;
        }
        return false; 
    } 
}
