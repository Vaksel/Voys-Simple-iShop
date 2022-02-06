<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Appeal extends Mailable
{
    use Queueable, SerializesModels;

    public $order;


    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->view('mails.appeal')
                    ->with([
                        'name' => $this->order->name,
                        'email' => $this->order->email,
                        'phone' => $this->order->phone,
                        'clientMessage' => $this->order->clientMessage,
                    ]);
    }
}
