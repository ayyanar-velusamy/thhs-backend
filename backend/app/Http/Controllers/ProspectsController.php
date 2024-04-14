<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProspectRequest;

use App\Mail\InterviewMail;
use App\Models\Language;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
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
        $user->start_date = update_date_format($request->input('dob'), "Y-m-d"); 
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
        $user->interview_date = update_date_format($request->input('interview_date'), "m-d-Y");

        Mail::to($user->email)->send(new InterviewMail($user));
        $this->response['status'] = true;
        $this->response['message'] = "Interview Scheduled successfully";
        $this->response['redirect_url'] = route('prospects.demographics', [$user->id]);
        return $this->response();
    }

    public function confirm_interview(Request $request, $id)
    {
        $user = User::find($id);
        $user->interview_date = update_date_format($request->input('interview_date'), "m-d-Y");
        $user->mail = "confirm_interview";

        Mail::to($user->email)->send(new InterviewMail($user));
        $this->response['status'] = true;
        $this->response['message'] = "Interview Confirmed";
        $this->response['redirect_url'] = route('prospects.demographics', [$user->id]);
        return $this->response();
    }
}
