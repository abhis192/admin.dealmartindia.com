<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NewRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    // public $data;
    public $user;
    /**
     * Create a new message instance.
     *
     * @param  $data
     * @return void
     */
    // public function __construct(array $data)
    // {
    //     $this->data = $data;
    // }

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New User Registered.')
                    ->view('emails.new_user_registered');
    }
}
