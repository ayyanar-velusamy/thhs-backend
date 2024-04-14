<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalInfoRequest;
use App\Mail\PersonalInfoEmail;
use App\Models\EmergencyContacts;
use App\Models\Language;
use App\Models\Position;
use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PersonalInformationController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //    $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    // public function authorize()
    // {
    //     return true;
    // }

    public function personal_info(Request $request, $id)
    {
        $data = $this->getPersonalInfoData($id);
        return view('prospect_personal_info', compact("data"));
    }
    public function getPersonalInfoData($id)
    {
        $languages = Language::all();
        $positions = Position::all();
        $user = User::with("emergency_contacts")->with("work_history")->findOrFail($id);
        return ["languages" => $languages, "user" => $user, "positions" => $positions];
    }

    public function update_personal_info(PersonalInfoRequest $request, $id)
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
        $user->status = 2; // Personal Infor Form submitted.
        $user->signature_path = $this->save_signature($request);
        
        // pr($request->all(),1);
     
        if($user->save()){ 
           
           
            $this->save_work_history_data($request);
            $this->save_emergency_contacts($request);
            
            Mail::to($user->email)->send(new PersonalInfoEmail($user));
            $this->response['status']   = true;
            $this->response['message']  = "Thanks for submission. Please wait for further notiication via email";
            $this->response['redirect_url']  = route("logout");
        }else{
            $this->response['status']   = false;
            $this->response['message']  = "Personal information update failed";
        } 
        return $this->response();
    }

    public function save_work_history_data($request){
        $employers = array_filter($request->input("employer"));
        foreach($employers as $key => $employer){
            $work_history = new WorkHistory;
            $work_history->user_id = Auth::user()->id;
            $work_history->employer_name = $employer;
            $work_history->position = $request->input("prev_position")[$key];
            $work_history->supervisor_name = $request->input("supervisor")[$key];
            $work_history->employer_email = $request->input("employer_email")[$key];
            $work_history->employer_fax = $request->input("employer_fax")[$key];
            $work_history->employer_phone = $request->input("employer_phone")[$key];
            $work_history->save();
        }
    }

    public function save_emergency_contacts($request){
        $relationships = array_filter($request->input("relationship"));
        foreach($relationships as $key => $relationship){
            $work_history = new EmergencyContacts;
            $work_history->user_id = Auth::user()->id;
            $work_history->relationship = $relationship;
            $work_history->relationship_name = $request->input("relationship_name")[$key];
            $work_history->relationship_email = $request->input("relationship_email")[$key];
            $work_history->relationship_phone = $request->input("relationship_phone")[$key];
            $work_history->save();
        }
    }


    private function save_signature($request){

        $folderPath = 'upload/signature/'; 
        $image_parts = explode(";base64,", $request->input('signed'));
              
        $image_type_aux = explode("image/", $image_parts[0]);
           
        $image_type = $image_type_aux[1];
           
        $image_base64 = base64_decode($image_parts[1]);
  
        $filename = uniqid() . '.'.$image_type;
        $file = public_path($folderPath) . $filename; 
        file_put_contents($file, $image_base64);
       return $folderPath.$filename;
    }
}
