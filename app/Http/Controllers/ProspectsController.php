<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProspectRequest;

use App\Mail\InterviewMail;
use App\Mail\PersonalInfoEmail;
use App\Models\EmergencyContacts;
use App\Models\Language;
use App\Models\Position;
use App\Models\ProfessionalReferences;
use App\Models\ProspectStatus;
use App\Models\User;
use App\Models\UserEducation;
use App\Models\WorkHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class ProspectsController extends BaseController
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
    public function index()
    {
        // $prospect_list = User::all()->sortByDesc("id");
        $prospect_list = User::where(['is_admin' => 0,'user_type' => 2])->select('*')->orderBy('id', 'desc')->get();
        $positions = Position::all();
        $prospect_statuses = ProspectStatus::all();
        foreach ($prospect_list as $prospect) {
            $position = Position::where("id", $prospect->position)->first();
            $prospect->short_name = $position->short_name;
            $prospect->position = $position->position;
        }
        foreach ($prospect_list as $prospect) {
            $prospect_status = ProspectStatus::where("id", $prospect->prospect_status)->first();
            if($prospect_status){
                $prospect->prospect_status = $prospect_status->status;
            }else{
                $prospect->prospect_status = "Active";
            }
            
        }
        return view('prospects/prospect', compact("prospect_list", "positions"));
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

    public function add_prospect(AddProspectRequest $request)
    {
        $user = new User();
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->birth_date = update_date_format($request->input('dob'), "Y-m-d"); 
        $user->name = $request->input('firstname') . " " . $request->input('lastname');
        $user->email = $request->input('email');
        $user->gender = 3;
        $user->position = $request->input('position'); 
        $user->created_at = update_date_format($request->input('submit_date'), "Y-m-d"); 
        $user->status = 1;  
        $user->has_temp_password = 1;  
        $temp_pwd = Str::random(8);
        $user->password = bcrypt($temp_pwd);
        $user->user_type = 2; 
        
        // pr($request->all(),1);

        if ($user->save()) {   
            $user->temp_pwd = $temp_pwd;
            Mail::to($user->email)->send(new PersonalInfoEmail($user));
            $this->response['status'] = true;
            $this->response['message'] = "Prospect added successfully"; 
        } else {
            $this->response['status'] = false;
            $this->response['message'] = "Prospect adding failed";
        }
        return $this->response();
    }
    public function demographics(Request $request, $id)
    {
        $data = $this->getPersonalInfoData($id);
        return view('prospects/demographics', compact("data"));
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
        $user->address = $request->input('address'); 
        $user->state = $request->input('state'); 
        $user->city = $request->input('city'); 
        $user->zip = $request->input('zip');   
        $user->phone_home = remove_mask($request->input('phone_home'));   
        $user->business = $request->input('business');
        $user->cellular = remove_mask($request->input('cellular'));  
        $user->start_date = update_date_format($request->input('dob'),"Y-m-d");
        $user->has_convicted_felony = $request->input('has_convicted_felony'); 
        $user->convicted_reason = $request->input('convicted_reason'); 
        $user->has_reviewed_job_description = $request->input('has_reviewed_job_description');
        $user->can_perform_without_accomodation = $request->input('can_perform_without_accomodation');
        $user->special_skills = $request->input('special_skills'); 
        $user->had_influeza_vaccine = $request->input('had_influeza_vaccine'); 
        $user->influeza_vaccine_date = update_date_format($request->input('influeza_vaccine_date'),"Y-m-d");
        $user->influeza_vaccine_reason = $request->input('influeza_vaccine_reason'); 
        $user->had_hepatitis_vaccine = $request->input('had_hepatitis_vaccine');
        $user->hepatitis_vaccine_date = update_date_format($request->input('hepatitis_vaccine_date'),"Y-m-d");
        $user->hepatitis_vaccine_reason = $request->input('hepatitis_vaccine_reason');
        // $user->signature_path = $this->save_signature($request);
        
        // pr($request->all(),1);
     
        if($user->save()){ 
           
            $this->save_user_education($request);
            $this->save_professional_references($request);
            $this->save_work_history_data($request);
            $this->save_emergency_contacts($request);
            
            $this->response['status']   = true;
            $this->response['message']  = "Prospect details updated successfully";
            $this->response['redirect_url']  = route("prospects");
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

    public function schedule_interview(Request $request, $id)
    {
        $user = User::find($id);
        $user->interview_schedule_date = update_date_format($request->input('interview_date'), "Y-m-d H:i");
        $user->prospect_status = 5;
        if($user->save()){ 
            Mail::to($user->email)->send(new InterviewMail($user));
            $this->response['status'] = true;
            $this->response['message'] = "Interview Scheduled successfully";
            $this->response['redirect_url'] = route('prospects.demographics', [$user->id]);
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "Interview Schedule Failed";
            $this->response['redirect_url'] = route('prospects.demographics', [$user->id]);

        }
        
        return $this->response();
    }

    public function confirm_interview(Request $request, $id)
    {
        $user = User::find($id);
        $user->interview_confirm_date =update_date_format($request->input('interview_date'), "Y-m-d H:i");
        $user->prospect_status = 6;
        
        if($user->save()){ 
            $user->mail = "confirm_interview";
            Mail::to($user->email)->send(new InterviewMail($user));
            $this->response['status'] = true;
            $this->response['message'] = "Interview Confirmed";
            $this->response['redirect_url'] = route('prospects.demographics', [$user->id]);
            
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "Interview Confirmation Failed";
            $this->response['redirect_url'] = route('prospects.demographics', [$user->id]);
        }
        return $this->response();
        
    }

    public function cancel_interview(Request $request, $id)
    {
            $user = User::find($id);
            $user->prospect_status = 7;
            $user->interview_cancellation_reason = $request->input('cancellation_reason');
        // $user->interview_confirm_date = update_date_format($request->input('interview_date'), "Y-m-d");
        
        if($user->save()){ 
            $user->mail = "cancel_interview";
            // Mail::to($user->email)->send(new InterviewMail($user));
            $this->response['status'] = true;
            $this->response['message'] = "Interview Cancelled";
            
            
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "Interview Confirmation Failed";
            
        }
        return $this->response();
        
    }

    public function reject_prospect(Request $request, $id)
    {
            $user = User::find($id);
            $user->prospect_status = 8;
        // $user->interview_confirm_date = update_date_format($request->input('interview_date'), "Y-m-d");
        
        if($user->save()){ 
            // $user->mail = "cancel_interview";
            // Mail::to($user->email)->send(new InterviewMail($user));
            $this->response['status'] = true;
            $this->response['message'] = "Prospect Rejected";
            
            
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "Prospect Rejection Failed";
            
        }
        return $this->response();
        
    }
    public function reapply_prospect(Request $request, $id)
    {
            $user = User::find($id);
            $user->prospect_status = 10;
        // $user->interview_confirm_date = update_date_format($request->input('interview_date'), "Y-m-d");
        
        if($user->save()){ 
            // $user->mail = "cancel_interview";
            // Mail::to($user->email)->send(new InterviewMail($user));
            $this->response['status'] = true;
            $this->response['message'] = "Prospect changed to Re Apply";
            
            
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "Prospect status updation Failed";
            
        }
        return $this->response();
        
    }

    public function archive_prospect(Request $request, $id)
    {
            $user = User::find($id);
            $user->prospect_status = 9;
        // $user->interview_confirm_date = update_date_format($request->input('interview_date'), "Y-m-d");
        
        if($user->save()){ 
            // $user->mail = "cancel_interview";
            // Mail::to($user->email)->send(new InterviewMail($user));
            $this->response['status'] = true;
            $this->response['message'] = "Prospect archived";
            
            
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "Prospect archive Failed";
            
        }
        return $this->response();
        
    }

    
    

    public function hire_prospect(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $user->hire_date = update_date_format($request->input('hire_date'), "Y-m-d");
        $user->prospect_status = 12;
        $user->user_type = 1;
        $user->status = 1;
        $user->staff_status = 1;
        
        if($user->save()){ 
            $this->response['status'] = true;
            $this->response['message'] = "Hire date updated successsfully";
            
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "Interview Confirmation Failed";
        }
        return $this->response();
        
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

    public function save_emergency_contacts($request){
        $relationships = array_filter($request->input("relationship"));
        foreach($relationships as $key => $relationship){
            $emergency_contact = new EmergencyContacts;
            if(@$request->input("emergency_contact_id")[$key] != ""){
                $emergency_contact = EmergencyContacts::find($request->input("emergency_contact_id")[$key]);
                $emergency_contact->id = $request->input("emergency_contact_id")[$key];    
            }
            $emergency_contact->user_id = $request->input("user_id");;
            $emergency_contact->relationship_id = $relationship;
            $emergency_contact->relationship_name = $request->input("relationship_name")[$key];
            $emergency_contact->relationship_email = $request->input("relationship_email")[$key];
            $emergency_contact->relationship_phone = remove_mask($request->input("relationship_phone")[$key]);
            $emergency_contact->save();
        }
    }
}
