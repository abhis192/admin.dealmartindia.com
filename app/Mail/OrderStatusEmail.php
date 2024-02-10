<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $data)
    {
        $this->order = $order;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Status Update')
        ->view('emails.order_status_email') // Use the email template view
        ->with([
            'order' => $this->order,
            'data' => $this->data
        ]);
    }
}
