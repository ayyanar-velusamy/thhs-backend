<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Mail;


class UserController extends BaseController
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
        return view('users/user');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function add_prospect(AddProspectRequest $request)
    // {
    //     $user = new User();
    //     $user->firstname = $request->input('firstname');
    //     $user->middlename = $request->input('middlename');
    //     $user->lastname = $request->input('lastname');
    //     $user->birth_date = update_date_format($request->input('dob'), "Y-m-d"); 
    //     $user->name = $request->input('firstname') . " " . $request->input('lastname');
    //     $user->email = $request->input('email');
    //     $user->gender = 3;
    //     $user->position = $request->input('position'); 
    //     $user->created_at = update_date_format($request->input('submit_date'), "Y-m-d"); 
    //     $user->status = 1;  
    //     $user->has_temp_password = 1;  
    //     $temp_pwd = Str::random(8);
    //     $user->password = bcrypt($temp_pwd);
    //     $user->user_type = 2; 
        
    //     // pr($request->all(),1);

    //     if ($user->save()) {   
    //         $user->temp_pwd = $temp_pwd;
    //         Mail::to($user->email)->send(new PersonalInfoEmail($user));
    //         $this->response['status'] = true;
    //         $this->response['message'] = "Prospect added successfully"; 
    //     } else {
    //         $this->response['status'] = false;
    //         $this->response['message'] = "Prospect adding failed";
    //     }
    //     return $this->response();
    // }
    
}
