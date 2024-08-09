<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chart;
use App\Models\ChartCategory;
use App\Models\Interval;
use App\Models\Handling;
use App\Models\Report;
use App\Models\Position;




use DB;

class ChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('DB_MIGRATION', 0) == 1) { 
            $this->chart_table_migration();  
            //SELECT staffchartalert.*, GROUP_CONCAT(staffchartrole.StaffRoleId) AS role_ids FROM `staffchartalert` LEFT JOIN staffchartrole ON staffchartrole.StaffChartAlertId = staffchartalert.StaffChartAlertId GROUP BY staffchartalert.StaffChartAlertId;
        } 
    }

    public function chart_table_migration()
    {
        // $old_record = DB::connection('mysql_old')->table('staffchartalert')->where('staffchartalert.StaffChartAlertId', 229)->get();
        $old_record = DB::connection('mysql_old')->table('staffchartalert')->get();
        $chart_roles = DB::connection('mysql_old')->select('SELECT  GROUP_CONCAT(staffchartrole.StaffRoleId) AS role_ids, staffchartalert.StaffChartAlertId  FROM staffchartalert LEFT JOIN staffchartrole ON staffchartrole.StaffChartAlertId = staffchartalert.StaffChartAlertId GROUP BY StaffChartAlertId'); 

        foreach ($old_record as $data) { 

            $relation = $this->search_exit($chart_roles, "StaffChartAlertId", strtolower($data->StaffChartAlertId));  
            $positions = Position::select('id')->whereIn("old_id", explode(",",$relation->role_ids))->get()->pluck('id'); 
            $category_id = ChartCategory::where("uid", $data->CategoryIdU)->first()->id;
            $valid_interval = 3;
            if($data->ValidForTypeIdU){
                $valid_interval =  Interval::where("uid", $data->ValidForTypeIdU)->first()->id;
            }
            $renewal_interval = 3;
            if($data->RenewalPeriodTypeIdU){
                $renewal_interval = Interval::where("uid", $data->RenewalPeriodTypeIdU)->first()->id;
            }
            $provide_interval = 3;
            if($data->MustProvidePeriodTypeIdU){
                $provide_interval = Interval::where("uid", $data->MustProvidePeriodTypeIdU)->first()->id;
            } 
            $handling = Handling::where("uid", $data->ChartHandlingId)->first()->id;
     
            $chart = new Chart(); 
            $chart->user_id = 1;
            $chart->group = $category_id;
            $chart->name = $data->ChartName;
            $chart->required = $data->IsRequired;
            $chart->valid_interval = $valid_interval;
            $chart->valid_number = $data->ValidFor;
            $chart->renewal_interval = $renewal_interval;
            $chart->renewal_number = $data->RenewalPeriod;
            $chart->provide_interval = $provide_interval;
            $chart->provide_number = $data->MustProvidePeriod;
            $chart->old_id = $data->StaffChartAlertId; 
      
            $chart->chart_handling = $handling; 
            $chart->created_by = 1; 
            if ($chart->save()) { 
                if($chart->chart_handling == "2"){
                    $this->save_report($chart);
                } 
                $chart->positions()->attach($positions); 
            }
        }
    }

    function save_report($chart){
        $report = new Report();   
        $report->name = $chart->name; 
        $report->chart_id =  $chart->id; 
        $report->report_id =  uniqid(); 
        $report->category_id = $chart->group;  
        $report->status = 0;  
        $report->created_by = 1;
        $report->save();

    }

    public function search_exit($exif, $field, $value){
        foreach ($exif as $data)
        {  
            if ($data->{$field} == $value){
                return $data;
            } 
        }
        return 0;
    }
}
