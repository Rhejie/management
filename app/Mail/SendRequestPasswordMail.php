<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRequestPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token, $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $body)
    {
        $this->token = $token;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->subject('Password Reset')->view('emails.passwordresetmail', [
            'token' => $this->token,
            'body' => $this->body
        ]);
    }
}
