<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Mail\RegisterEmail;
use App\Models\ChartPosition;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return $request->validate( [
            'authorize_to_us' => ['required'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'position' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['required', new Recaptcha],
        ],$this->validationErrorMessages());
    }


    protected function validationErrorMessages()
    {
        return [
			'authorize_to_us.required' 	=> "Email ID cannot be empty",
			'firstname.required' 		=> "Firstname cannot be empty",
			'lastname.required' 		=> "Lastname cannot be empty",
			'position.required' 		=> "Position cannot be empty",
			'email.exists' 		=> "Email address already exists",
			// 'password.required' => "Password cannot be empty",
            'g-recaptcha-response.required' => "Verify the Recaptcha"
		];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(array $data)
    // {  
    //     $post_data = [
    //         'name' => $data['firstname'] . " " . $data['lastname'],
    //         'firstname' => $data['firstname'],
    //         'lastname' => $data['lastname'],
    //         'email' => $data['email'],
    //         'position' => $data['position'], 
    //         'password' => Hash::make($data['password'])
    //     ]; 

    //     if(User::create($post_data)){
    //         // Mail::to($data['email'])->send(new RegisterEmail($post_data));  
    //         return back()->with('message', 'Registration successfully');
    //     } 
    // }

    public function register(Request $request)
    {

        $data = $request->all();
        $this->validator($request);
        $user = new User();
        $user->name = $data['firstname'] . " " . $data['lastname'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        // $user->password = Hash::make($data['password']);
        $user->position = $data['position'];
        $user->prospect_status = 1;
        $user->user_type = 2; 
        $temp_pwd = Str::random(8);
        $user->password = bcrypt($temp_pwd);
        

        
        if ($user->save()) {
            $user->temp_pwd = $temp_pwd;
              
            Mail::to($data['email'])->send(new RegisterEmail($user));
            return back()->with('message', 'You have registered successfully. Please chek your email to complete the registeration');
        } else {
            return back()->with('message', 'Registration failed');
        }

    }

}
