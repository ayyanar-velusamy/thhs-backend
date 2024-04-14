<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class InterviewMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $tpl;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->user = $data;
        switch ($this->user->mail) {
            case "confirm_interview":
              $this->tpl = $this->user->mail;
              $this->subject = "Interview Confirmed";
              break;
            case "cancel_interview":
                $this->tpl = $this->user->mail;
                $this->subject = "Interview Cancelled";
                break;
            default:
                $this->tpl = "schedule_interview";
                $this->subject = "Interview Scheduled";
          }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'THHS - '.$this->subject;
        return $this->view('email.'.$this->tpl)
            ->with(['user' => $this->user])
            ->subject($subject);
    }

}
