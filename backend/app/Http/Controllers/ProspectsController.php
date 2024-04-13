<?php

namespace App\Http\Controllers;

use App\Mail\InterviewMail;
use Illuminate\Http\Request;

use App\Models\Language;
use App\Models\Position;
use App\Models\User;
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
        $prospect_list = User::all();
        foreach($prospect_list as $prospect){
            $position = Position::where("id",$prospect->position)->first()->position;
            $prospect->position = $position;
        }
        return view('prospects/prospect',compact("prospect_list"));
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
    public function demographics(Request $request, $id)
    {
        $data = $this->getPersonalInfoData($id);
        return view('prospects/demographics',compact("data"));
    }

    public function getPersonalInfoData($id){
        $languages = Language::all();
        $positions = Position::all();
        $user = User::with("emergency_contacts")->with("work_history")->findOrFail($id);
        return ["languages"=>$languages,"user"=>$user,"positions"=>$positions];
    }

    
    public function schedule_interview(Request $request, $id)
    {
        $user = User::find($id);  
        $user->interview_date = update_date_format($request->input('interview_date'),"m-d-Y");
        
        Mail::to($user->email)->send(new InterviewMail($user));
        $this->response['status']   = true;
        $this->response['message']  = "Interview Scheduled successfully";
        $this->response['redirect_url']  = route('prospects.demographics', [$user->id]);
        return $this->response();
    }

    public function confirm_interview(Request $request, $id)
    {
        $user = User::find($id);  
        $user->interview_date = update_date_format($request->input('interview_date'),"m-d-Y");
        $user->mail = "confirm_interview";
        
        Mail::to($user->email)->send(new InterviewMail($user));
        $this->response['status']   = true;
        $this->response['message']  = "Interview Confirmed";
        $this->response['redirect_url']  = route('prospects.demographics', [$user->id]);
        return $this->response();
    }
}
