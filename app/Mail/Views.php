<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class Views extends Mailable
{
    use Queueable, SerializesModels;

    public $subject,$myview,$user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$view,$user)
    {

        $this->subject=$subject;
        $this->myview=$view;
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.views');
    }
}
