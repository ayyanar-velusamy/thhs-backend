<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Password;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */

    use SendsPasswordResetEmails;
    public function sendResetLinkEmail(Request $request)
    { 
        $this->validateEmail($request);

        $valid = User::whereEmail($request->input("email"))->first();       
        if($valid){
            if($valid->user_type === 2 && $valid->prospect_status === 3){
                return back()
                       ->with('error', 'Your application is in progress');
            } 
        }       
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
        ? $this->sendResetLinkResponse($request, $response)
        : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('success', 'Password reset email sent. Please check your email');

    }
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->with('error', 'Email Address not exists!');
    }
}
