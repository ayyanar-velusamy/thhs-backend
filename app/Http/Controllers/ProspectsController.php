<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProspectRequest;

use App\Mail\InterviewMail;
use App\Models\EmergencyContacts;
use App\Models\Language;
use App\Models\Position;
use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $prospect_list = User::all()->sortByDesc("id");
        $positions = Position::all();
        foreach ($prospect_list as $prospect) {
            $position = Position::where("id", $prospect->position)->first()->position;
            $prospect->position = $position;
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
        $user->position = $request->input('position'); 
        $user->created_at = update_date_format($request->input('submit_date'), "Y-m-d"); 
        $user->status = 1;  

        // pr($request->all(),1);

        if ($user->save()) {   
            // Mail::to($user->email)->send(new PersonalInfoEmail($user));
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
        
        $user = User::find($id);
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->birth_date = update_date_format($request->input('dob'),"Y-m-d");
        $user->gender = $request->input('gender');
        $user->language_id = $request->input('languages');
        $user->ssn = $request->input('ssn');
        $user->employement_authorization = $request->input('employeement_authorization');
        $user->corporation_name = $request->input('corporation_name');
        $user->name = $request->input('firstname') . $request->input('middlename') . $request->input('lastname'); 
        // $user->email = $request->input('email');  
        $user->position = $request->input('position');  
        $user->tax_id = $request->input('tax_id');  
        $user->address = $request->input('address'); 
        $user->state = $request->input('state'); 
        $user->city = $request->input('city'); 
        $user->zip = $request->input('zip');   
        $user->phone_home = $request->input('phone_home');   
        $user->business = $request->input('business');
        $user->cellular = $request->input('cellular');  
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
        // $user->status = 2; // Personal Infor Form submitted.
        // $user->signature_path = $this->save_signature($request);
        
        // pr($request->all(),1);
     
        if($user->save()){ 
           
           
            $this->save_work_history_data($request,$id);
            $this->save_emergency_contacts($request,$id);
            
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
        $user = User::with("emergency_contacts")->with("work_history")->findOrFail($id);
        return ["languages" => $languages, "user" => $user, "positions" => $positions];
    }

    public function schedule_interview(Request $request, $id)
    {
        $user = User::find($id);
        $user->interview_schedule_date = update_date_format($request->input('interview_date'), "Y-m-d");

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
        $user->interview_confirm_date = update_date_format($request->input('interview_date'), "Y-m-d");
        
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
        // $user->interview_confirm_date = update_date_format($request->input('interview_date'), "Y-m-d");
        
        
            $user->mail = "cancel_interview";
            Mail::to($user->email)->send(new InterviewMail($user));
            $this->response['status'] = true;
            $this->response['message'] = "Interview Cancelled";
            $this->response['redirect_url'] = route('prospects.demographics', [$user->id]);
            
        // }else{
        //     $this->response['status'] = false;
        //     $this->response['message'] = "Interview Confirmation Failed";
        //     $this->response['redirect_url'] = route('prospects.demographics', [$user->id]);
        // }
        return $this->response();
        
    }

    public function hire_prospect(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $user->hire_date = update_date_format($request->input('hire_date'), "Y-m-d");
        
        if($user->save()){ 
            $this->response['status'] = true;
            $this->response['message'] = "Hire date updated successsfully";
            
        }else{
            $this->response['status'] = false;
            $this->response['message'] = "Interview Confirmation Failed";
        }
        return $this->response();
        
    }


    public function save_work_history_data($request,$id){
        $employers = array_filter($request->input("employer"));
        foreach($employers as $key => $employer){
            $work_history = new WorkHistory;
            $work_history->user_id = $id;
            $work_history->employer_name = $employer;
            $work_history->position = $request->input("prev_position")[$key];
            $work_history->supervisor_name = $request->input("supervisor")[$key];
            $work_history->employer_email = $request->input("employer_email")[$key];
            $work_history->employer_fax = $request->input("employer_fax")[$key];
            $work_history->employer_phone = $request->input("employer_phone")[$key];
            $work_history->save();
        }
    }

    public function save_emergency_contacts($request,$id){
        $relationships = array_filter($request->input("relationship"));
        foreach($relationships as $key => $relationship){
            $work_history = new EmergencyContacts;
            $work_history->user_id = $id;
            $work_history->relationship = $relationship;
            $work_history->relationship_name = $request->input("relationship_name")[$key];
            $work_history->relationship_email = $request->input("relationship_email")[$key];
            $work_history->relationship_phone = $request->input("relationship_phone")[$key];
            $work_history->save();
        }
    }
}
