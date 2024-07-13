<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveChartRequest;
use App\Http\Requests\SaveChartCategoryRequest; 
use App\Models\Chart;
use App\Models\ChartCategory;
use App\Models\ChartPosition;
use App\Models\Document;
use App\Models\Position;
use App\Models\Handling; 
use App\Models\Interval;
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

        $chart_list = Chart::where(['status' => 1])->select('*')->orderBy('id', 'desc')->get();
        $intervals = Interval::all();
        $handlings = Handling::all(); 
        $categories = ChartCategory::all();        
        $positions = Position::all();        

        foreach ($chart_list as $chart) {
            $valid_interval = Interval::where("id", $chart->valid_interval)->first()->name;
            @$renewal_interval = @Interval::where("id", $chart->renewal_interval)->first()->name;
            @$provide_interval = @Interval::where("id", $chart->provide_interval)->first()->name;
            $chart_handling = Handling::where("id", $chart->chart_handling)->first()->name;
            $category = ChartCategory::where("id", $chart->group)->first()->name; 

            $chart->valid_interval = $valid_interval;
            $chart->renewal_interval = @$renewal_interval;
            $chart->provide_interval = @$provide_interval;
            $chart->chart_handling = $chart_handling;
            $chart->category = $category;
          
        }
        return view('reports/report', compact("chart_list", "intervals", "handlings", "categories", "positions"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
 
    public function designer(Request $request)
    {
        // $chart = Chart::find($id);
        // $chart->status = 2; 
        $report_data['id'] = $request->query('reportId');
 
        return view('designer', compact("report_data"));
     
    }  
   
}
