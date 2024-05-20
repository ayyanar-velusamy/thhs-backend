<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function index(Request $request)
    {

        $user_list = User::where(['is_admin' => 0, 'user_type' => 3, 'status' => 1])->select('*')->orderBy('id', 'desc')->get();

        return view('users/user', compact("user_list"));
    }

    public function save_user(SaveUserRequest $request)
    {
        // exit;
        $user = new User();
        if ($request->input('id')) {
            $user = User::find($request->input('id'));
        }
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->name = $request->input('firstname') . $request->input('lastname');
        $user->email = $request->input('email');
        $user->cellular = remove_mask($request->input('phone_number'));  
        $user->account_expire_date = update_date_format($request->input('account_expire_date'), "Y-m-d");
        $user->password_expire_date = update_date_format($request->input('password_expire_date'), "Y-m-d");
        $user->app_user_status = $request->input('status');
        $user->role = 3;
        $user->user_type = 3; 
        $user->status = 1; 

        if($request->input('password') && $request->input('password') !== "TextPassword#003"){
            $user->password =  Hash::make($request->input('password'));
        }

        // pr($request->all(),1);
        if ($user->save()) {
            $this->response['status'] = true;
            $this->response['message'] = "User saved successfully";
        } else {
            $this->response['status'] = false;
            $this->response['message'] = "User saving failed";
        }
        return $this->response();
    }

    public function get_user(Request $request, $id)
    {
        $data = $this->getUserInfoData($id);
        $this->response = compact("data");
        return $this->response();
    }

    public function getUserInfoData($id)
    {
        $user = User::findOrFail($id);
        return ["user" => $user];
    }

    public function delete_user(Request $request, $id)
    { 
        $user = User::where('id', $id)->firstorfail()->delete(); 
        if ($user) {
            $this->response['status'] = true;
            $this->response['message'] = "User deleted Successfully";

        } else {
            $this->response['status'] = false;
            $this->response['message'] = "User deleted Failed";

        }
        return $this->response();
    }  

}
