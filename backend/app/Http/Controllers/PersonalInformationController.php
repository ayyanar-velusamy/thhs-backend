<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalInfoRequest;
use App\Models\Language;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

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
        // $user->birth_date = $request->input('dob');
        $user->gender = $request->input('gender');
        $user->language_id = $request->input('languages');
        $user->ssn = $request->input('ssn');  
        $user->name = $request->input('firstname') . $request->input('middlename') . $request->input('lastname'); 
        $user->email = $request->input('email');  
        $user->position = $request->input('position');  
        $user->address = $request->input('address'); 
        $user->state = $request->input('state'); 
        $user->city = $request->input('city'); 
        $user->zip = $request->input('zip');   
        $user->cellular = $request->input('cellular');  
        // $user->start_date = $request->input('start_date');  
    

        if($user->save()){ 
            $this->response['status']   = true;
            $this->response['message']  = "Personal information updated";
 
         
        }else{
            $this->response['status']   = false;
            $this->response['message']  = "Personal information update failed";
        } 
        return $this->response();
    }

}
