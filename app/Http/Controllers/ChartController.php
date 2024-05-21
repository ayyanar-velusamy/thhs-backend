<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveChartRequest;
use App\Http\Requests\SaveChartCategoryRequest; 
use App\Models\Chart;
use App\Models\ChartCategory;
use App\Models\Handling; 
use App\Models\Interval;
use App\Models\User;
use Illuminate\Http\Request;

class ChartController extends BaseController
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
        $handlings = Handling::all();
        $categories = ChartCategory::all();        

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
        return view('charts/chart', compact("chart_list", "intervals", "handlings", "categories"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function save_chart(SaveChartRequest $request)
    {
        // exit;
        $chart = new Chart();
        if ($request->input('id')) {
            $chart = Chart::find($request->input('id'));
        }
        $chart->user_id = $request->user()->id;
        $chart->group = $request->input('group');
        $chart->name = $request->input('name');
        $chart->required = $request->input('required');
        $chart->valid_interval = $request->input('valid_interval');
        $chart->valid_number = $request->input('valid_number');
        $chart->renewal_interval = $request->input('renewal_interval');
        $chart->renewal_number = $request->input('renewal_number');
        $chart->provide_interval = $request->input('provide_interval');
        $chart->provide_number = $request->input('provide_number');
        $chart->report = $request->input('report');
        $chart->chart_handling = $request->input('chart_handling'); 

        // pr($request->all(),1);
        if ($chart->save()) {
            $this->response['status'] = true;
            $this->response['message'] = "Chart saved successfully";
        } else {
            $this->response['status'] = false;
            $this->response['message'] = "Chart saving failed";
        }
        return $this->response();
    }
    public function get_chart(Request $request, $id)
    {
        $data = $this->getChartInfoData($id);
        $this->response = compact("data");
        return $this->response();
    }

    public function getChartInfoData($id)
    {
        $chart = Chart::findOrFail($id);
        return ["chart" => $chart];
    }

    public function delete_chart(Request $request, $id)
    {
        $chart = Chart::find($id);
        $chart->status = 2;

        if ($chart->save()) {
            $this->response['status'] = true;
            $this->response['message'] = "Chart deleted Successfully";

        } else {
            $this->response['status'] = false;
            $this->response['message'] = "Chart deleted Failed";

        }
        return $this->response();
    } 

    public function save_chart_category(SaveChartCategoryRequest $request)
    {
        // exit;
        $category = new ChartCategory(); 
      
        $category->name = $request->input('category'); 
        if ($category->save()) {
            $this->response['status'] = true;
            $this->response['message'] = "Chart Category saved successfully";
        } else {
            $this->response['status'] = false;
            $this->response['message'] = "Chart Category saving failed";
        }
        return $this->response();
    }

}