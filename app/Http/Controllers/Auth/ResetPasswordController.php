<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function verifyEmail(Request $request, $token = null)
    {
		$valid = User::whereRememberToken($token)->first();
    
    //Check token exist in database and expire time
		if($valid){
			$valid->remember_token = null; 
			$valid->status = 1; 
      $valid->prospect_status = 2;
			if($valid->save()){
				return redirect()->route('login')->with('message', 'Email Verification successful'); 
			}
		}
    }

    // protected function resetPassword($user, $password)
    // {
    //     $user->password = Hash::make($password);
    
    //     $user->setRememberToken(Str::random(60));
    
    //     $user->save();
    
    //     event(new PasswordReset($user));
    
    //     //you should comment below and redirect any route you want like:
    //       return redirect('login');
    //     // $this->guard()->login($user);
    // }

}
