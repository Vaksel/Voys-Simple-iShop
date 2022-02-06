<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @param $order
     * @return void
     */
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
        return $this->view('mails.order-shipped')
                    ->with([
                        'productId' => $this->order->productId,
                        'productName' => $this->order->productName,
                        'name' => $this->order->name,
                        'lastname'=> $this->order->lastname,
                        'email'   => $this->order->email,
                        'propertyName' => $this->order->propertyName,
                        'propertyValue' => $this->order->propertyValue,
                    ]);
    }
}
