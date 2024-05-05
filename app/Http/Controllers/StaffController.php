<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveStaffRequest;

use App\Mail\InterviewMail;
use App\Models\EmergencyContacts;
use App\Models\Language;
use App\Models\Position;
use App\Models\Organization;
use App\Models\StaffStatus;
use App\Models\UserRole;
use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class StaffController extends BaseController
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
        // $status = $request->query("status");
        // $staff_list = User::all()->sortByDesc("id");
        // if($status){
        //     $staff_list = User::where(['status' => $status])->select('*')->orderBy('id', 'desc')->get();
        // }
        $staff_list =  User::where(['is_admin' => 0])->select('*')->orderBy('id', 'desc')->get();
        $positions = Position::all();
        $roles = UserRole::all();
        $languages = Language::all();
        $organizations = Organization::all();
        $staff_statuses = StaffStatus::all();
        
        foreach ($staff_list as $staff) {
            $position = Position::where("id", $staff->position)->first()->position;
            $role = UserRole::where("id", $staff->role)->first()->role;
            $organization = Organization::where("id", $staff->organization)->first()->name;  
            $staff_status = StaffStatus::where("id", $staff->staff_status)->first()->status; 
            $staff->position = $position;
            $staff->role = $role;
            $staff->organization = $organization;
            $staff->staff_status_id = $staff->staff_status;
            $staff->staff_status = $staff_status;
        }
        return view('staffs/staff', compact("staff_list", "positions", "roles", "languages", "organizations", "staff_statuses"));
    }

    public function table()
    {
        return view('prospects/prospect2');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function save_staff(SaveStaffRequest $request)
    { 
        // exit;
        $user = new User();
        if($request->input('id')){
            $user = User::find($request->input('id'));
        }else{
            $user->email = $request->input('email');
        } 
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->birth_date = update_date_format($request->input('dob'), "Y-m-d"); 
        $user->name = $request->input('firstname') . " " . $request->input('lastname'); 
        $user->position = $request->input('position'); 
        $user->hire_date = update_date_format($request->input('submit_date'), "Y-m-d"); 
        $user->ssn = remove_mask($request->input('ssn'));
        $user->gender = $request->input('gender');   
        $user->language_id = $request->input('language');    
        $user->staff_status = $request->input('staff_status');     
        $user->role = $request->input('employment_type');   
        $user->termination_date = update_date_format($request->input('termination_date'), "Y-m-d"); 
        $user->corporation_name = $request->input('corporation_name');   
        $user->organization = $request->input('organization');    
        $user->tax_id = $request->input('tax_id');  
        if($request->input('signed')){
            $user->signature_path = $this->save_signature($request);
        }
      
        // pr($request->all(),1); 
        if ($user->save()) {   
            $this->response['status'] = true;
            $this->response['message'] = "Staff saved successfully"; 
        } else {
            $this->response['status'] = false;
            $this->response['message'] = "Staff saving failed";
        }
        return $this->response();
    }
    public function get_staff(Request $request, $id)
    {
        $data = $this->getStaffInfoData($id); 
        $this->response = compact("data");  
        return $this->response();
    }

    public function update_staff(Request $request, $id)
    {
        
        $user = User::find($id);
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->birth_date = update_date_format($request->input('dob'), "Y-m-d"); 
        $user->name = $request->input('firstname') . " " . $request->input('lastname'); 
        $user->position = $request->input('position'); 
        $user->hire_date = update_date_format($request->input('submit_date'), "Y-m-d"); 
        $user->ssn = $request->input('ssn');   
        $user->gender = $request->input('gender');   
        $user->language_id = $request->input('language');   
        $user->status = $request->input('status');   
        $user->role = $request->input('employment_type');   
        $user->termination_date = update_date_format($request->input('termination_date'), "Y-m-d"); 
        $user->corporation_name = $request->input('corporation_name');   
        $user->organization = $request->input('organization');    
        $user->tax_id = $request->input('tax_id');  
     
        if($user->save()){   
            $this->response['status']   = true;
            $this->response['message']  = "Staff details updated successfully"; 
        }else{
            $this->response['status']   = false;
            $this->response['message']  = "Staff details updated failed";
        } 
        return $this->response();
    }

    public function getStaffInfoData($id)
    { 
        $user = User::with("emergency_contacts")->with("work_history")->findOrFail($id);
        return ["staff" => $user];
    } 

    private function save_signature($request){

        $folderPath = 'uploads/signature/'; 
        $image_parts = explode(";base64,", $request->input('signed'));
              
        $image_type_aux = explode("image/", $image_parts[0]);
           
        $image_type = $image_type_aux[1];
           
        $image_base64 = base64_decode($image_parts[1]);
  
        $filename = uniqid() . '.'.$image_type;
        $file = base_path($folderPath) . $filename; 
        file_put_contents($file, $image_base64);
       return $folderPath.$filename;
    }

    public function delete_staff(Request $request, $id)
    {
            $user = User::find($id);
            $user->staff_status = 6; 
        
        if($user->save()){  
            $this->response['status'] = true;
            $this->response['message'] = "Staff deleted Successfully";
            
            
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "Staff deleted Failed";
            
        }
        return $this->response(); 
    }
}
