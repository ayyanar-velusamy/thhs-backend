<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class RegisterEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->user = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'THHS - Registered Successfully';
        return $this->view('email.register')
            ->with(['user' => $this->user, 'link' => $this->generateUrl()])
            ->subject($subject);
    }

    private function generateToken()
    {
        //Generate a new reset password token
        $token = app('auth.password.broker')->createToken($this->user);
        User::where(['email' => $this->user->email])->update(['remember_token' => $token]);
        return $token;

    }

    private function generateUrl()
    {
        return url('/verify/email/' . $this->generateToken());
    }
}
