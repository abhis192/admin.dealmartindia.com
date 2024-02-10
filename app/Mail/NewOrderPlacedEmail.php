<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NewOrderPlacedEmail extends Mailable
{
    use Queueable, SerializesModels;

    // public $data;
    public $order;
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

    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Placed Successfully.')
                    ->view('emails.new_order_placed');
    }
}
