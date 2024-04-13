<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Requests\PersonalInfoRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;  

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
        return view('prospect_personal_info',compact("data"));
    }
    public function getPersonalInfoData($id){
        $languages = Language::all();
        $positions = Position::all();
        $user = User::with("emergency_contacts")->with("work_history")->findOrFail($id);
        return ["languages"=>$languages,"user"=>$user,"positions"=>$positions];
    }

    public function add_personal_info(PersonalInfoRequest $request)
	{
        // $user = new User();
        // $user->first_name   = $request->first_name;
        // $user->last_name    = $request->last_name;
        // $user->email    	= $request->email;
        // $user->password 	= Hash::make(str_random(35));
        // $user->mobile   	= $request->mobile;
		// //$user->status   	= $request->status;
        // $user->designation  = $request->designation;
        // $user->team  		= $request->team;
        // $user->department  	= $request->department;
        
        // if ($request->hasFile('image')) {
        //     $user->image = $this->profileUpload($request);
        // }
              
        // if($user->save()){ 
		//     $this->syncPermissions($request, $user);
			
		// 	$this->response['status']   = true;
		// 	$this->response['message']  = str_replace("{username}",$request->first_name." ".$request->last_name,__('message.user_create_success'));
		// 	$this->response['redirect'] = route('users.index');
			
		// 	try{
		// 		//User Invite mail notification
		// 		Mail::to($user)->send(new UserInviteEmail($user));
		// 		//$user->notify(new WelcomeNotification($user));
		// 	}
		// 	catch(\Exception $e){ // Using a generic exception
		// 		$this->response['message']  = __('message.mail_not_send');
		// 	}
		// }else{
		// 	$this->response['status']   = false;
		// 	$this->response['message']  = str_replace("{username}",$request->first_name." ".$request->last_name,__('message.user_create_failed'));
		// }
            return true;
        // return $this->response();
    }

}
