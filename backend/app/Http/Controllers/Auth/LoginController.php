<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\Recaptcha;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers; 
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); 
    } 

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required','email','exists:users', 'string'],
            'password' => ['required', 'string', 'max:255'], 
            'g-recaptcha-response' => ['required', new Recaptcha],
        ], $this->validationErrorMessages());
    }
	
	
	public function login(Request $request)
    {
        $this->validateLogin($request); 

		$credentials = $this->credentials($request);
        
        if ($this->guard()->attempt($credentials, $request->filled('remember'))) {
            
			
			//get user what attempting to login
            $user = User::where($this->username(), $credentials[$this->username()])->first();
			
            //check if user activated & activation required, make autoactivation
            if(!$user->is_admin){
                if($user->status === 1) {  
                    return redirect('/thhs/prospect_personal_info/'.$user->id);
                } else if($user->status === 2){
                    return redirect('/logout')->with('message', 'Your application is under Verification. Please check your email for further updates');
                }
                else{
                    return back()->with('message', 'Your account is deactived');
                }
            }else{
                return redirect(RouteServiceProvider::HOME);
            }
            
             
        }else{
           // $credentials = [$this->username() => $credentials[$this->username()],'password' => $credentials['password']];
            // $user = User::where("email", "inr.cse@gmail.com")
            //             ->where("password","123123123")
            //             ->get();
            // pr($user,1);
            // if($user){
            //     if($user->status === 2){
            //         return back()->with('message', 'Your application is under Verification. Please check your email for further updates');
            //     }else{
            //         return back()->with('message', 'Your account is deactived');
            //     }
            // }else{
                return back()->with('error', 'Please check the credentials');
            // }
            
        }
    }
	

    protected function credentials(Request $request)
    {
        // $request->request->add(['status' => 1]);
        return $request->only($this->username(), 'password');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
     
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/login');
    }

    protected function validationErrorMessages()
    {
        return [
			'email.required' 	=> "Email ID cannot be empty",
			'email.email' 		=> "Enter a valid Email ID",
			'email.exists' 		=> "Please enter your registered Email ID",
			'password.required' => "Password cannot be empty",
            'g-recaptcha-response.required' => "Verify Recaptcha"
		];
    }
}
