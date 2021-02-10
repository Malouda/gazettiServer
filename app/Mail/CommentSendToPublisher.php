<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentSendToPublisher extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $file;

    public function __construct($file)
    {
        $this->file=$file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sendCommentsToPublisher')
            ->attach($this->file, [
                'as' => 'comments.xls',
                'mime' => 'application/xls',
            ]);
    }
}
