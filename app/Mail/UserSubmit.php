<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserSubmit extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $team;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $team)
    {
        $this->user = $user;
        $this->team = $team;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user-submit');
    }
}
