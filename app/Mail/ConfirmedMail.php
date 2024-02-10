<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailDetails)
    {
        $this->mailDetails = $mailDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your MbizSpare Booking Update.')
                    ->view('emails.confirmedMail');
    }
}
