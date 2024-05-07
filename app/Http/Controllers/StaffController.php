<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveStaffRequest;

use App\Mail\InterviewMail;
use App\Models\EmergencyContacts;
use App\Models\Language;
use App\Models\Position;
use App\Models\Organization;
use App\Models\ProfessionalReferences;
use App\Models\StaffStatus;
use App\Models\UserRole;
use App\Models\User;
use App\Models\UserEducation;
use App\Models\WorkHistory;
use App\Models\TerminationHistory;
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
        $staff_list =  User::where(['is_admin' => 0,'user_type' => 1])->select('*')->orderBy('id', 'desc')->get();
        $positions = Position::all();
        $roles = UserRole::all();
        $languages = Language::all();
        $organizations = Organization::all();
        $staff_statuses = StaffStatus::all();
        
        foreach ($staff_list as $staff) {
            $position = Position::where("id", $staff->position)->first()->position;
            $role = UserRole::where("id", $staff->role)->first()->role;
            $organization = Organization::where("id", $staff->organization)->first()->name;  
            @$staff_status = @StaffStatus::where("id", $staff->staff_status)->first()->status; 
            $staff->position = $position;
            $staff->role = $role;
            $staff->organization = $organization;
            $staff->staff_status_id = $staff->staff_status;
            @$staff->staff_status = $staff_status;
        }
        return view('staffs/staff', compact("staff_list", "positions", "roles", "languages", "organizations", "staff_statuses"));
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
    public function demographics(Request $request, $id)
    {
        $data = $this->getPersonalInfoData($id);
        return view('staffs/demographics', compact("data"));
    }
    public function update_demographics(Request $request, $id)
    {
        $request->request->add(['user_id' => $id]);
        $user = User::find($id);
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->birth_date = update_date_format($request->input('dob'),"Y-m-d");
        $user->gender = $request->input('gender');
        $user->language_id = $request->input('languages');
        $user->ssn = remove_mask($request->input('ssn'));
        $user->employement_authorization = $request->input('employeement_authorization');
        $user->corporation_name = $request->input('corporation_name');
        $user->name = $request->input('firstname') . " " . $request->input('lastname'); 
        // $user->email = $request->input('email');  
        $user->position = $request->input('position');  
        $user->tax_id = $request->input('tax_id');  
        // $user->signature_path = $this->save_signature($request);
        
        // pr($request->all(),1);
     
        if($user->save()){ 
           
            $this->save_user_education($request);
            $this->save_professional_references($request);
            $this->save_work_history_data($request);
            $this->save_termination_history($request);
            
            $this->response['status']   = true;
            $this->response['message']  = "Staff demographics details updated successfully";
            $this->response['redirect_url']  = route("staffs");
        }else{
            $this->response['status']   = false;
            $this->response['message']  = "Prospect details updated failed";
        } 
        return $this->response();
    }

    public function getPersonalInfoData($id)
    {
        $languages = Language::all();
        $positions = Position::all();
        $user = User::with("emergency_contacts")
                    ->with("work_history")
                    ->with("user_education")
                    ->with("professional_references")
                    ->findOrFail($id);
        // pr($user,1);
        return ["languages" => $languages, "user" => $user, "positions" => $positions];
    }

    
    public function save_professional_references($request){
        $references = array_filter($request->input("reference_relationship"));
        // pr($request->input("reference_relationship_id"),1);
        foreach($references as $key => $reference){
            $user_references = new ProfessionalReferences;
            if(@$request->input("reference_relationship_id")[$key] != ""){
                $user_references = ProfessionalReferences::find($request->input("reference_relationship_id")[$key]);
                $user_references->id = $request->input("reference_relationship_id")[$key];    
            }
            $user_references->user_id = $request->input("user_id");;
            $user_references->relationship_id = $reference;
            $user_references->name = $request->input("reference_name")[$key];
            $user_references->email = $request->input("reference_email")[$key];
            $user_references->phone = remove_mask($request->input("reference_phone")[$key]);
           
            $user_references->save();
            
        }
    }

    public function save_work_history_data($request){
        $employers = array_filter($request->input("employer"));
        foreach($employers as $key => $employer){
            $work_history = new WorkHistory;
            if(@$request->input("employer_id")[$key] != ""){
                $work_history = WorkHistory::find($request->input("employer_id")[$key]);
                $work_history->id = $request->input("employer_id")[$key];    
            }
            $work_history->user_id = $request->input("user_id");;
            $work_history->employer_name = $employer;
            $work_history->position = $request->input("prev_position")[$key];
            $work_history->supervisor_name = $request->input("supervisor")[$key];
            $work_history->employer_email = $request->input("employer_email")[$key];
            $work_history->employer_fax = $request->input("employer_fax")[$key];
            $work_history->employer_phone = remove_mask($request->input("employer_phone")[$key]);
            $work_history->save();
        }
    }

    public function save_user_education($request){
        $education_types = array_filter($request->input("education_type"));
        
        foreach($education_types as $key => $education_type){
            $user_education = new UserEducation;
            if(@$request->input("education_id")[$key] != ""){
                $user_education = UserEducation::find($request->input("education_id")[$key]);
                $user_education->id = $request->input("education_id")[$key];    
            }
            $user_education->user_id = $request->input("user_id");
            $user_education->type_id = $education_type;
            $user_education->name = $request->input("education_name")[$key];
            $user_education->date_completed =  update_date_format($request->input("education_date_completed")[$key],"Y-m-d");
            $user_education->degree_id = $request->input("education_degree")[$key];
           
            $user_education->save();
        }
        
    }
    public function save_termination_history($request){
        $termination_dates = array_filter($request->input("termination_date"));
        foreach($termination_dates as $key => $termination_date){
            $termination_history = new TerminationHistory;
            if(@$request->input("termination_history_id")[$key] != ""){
                $termination_history = TerminationHistory::find($request->input("termination_history_id")[$key]);
                $termination_history->id = $request->input("termination_history_id")[$key];    
            }
            $termination_history->user_id = $request->input("user_id");
            $termination_history->hire_date = update_date_format($request->input("hire_date")[$key],"Y-m-d");
            $termination_history->termination_date = update_date_format($termination_date,"Y-m-d");
            $termination_history->terminated_by = $request->input("terminated_by")[$key];
            $termination_history->save();
        }
    }
}
