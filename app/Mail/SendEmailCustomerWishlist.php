<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailCustomerWishlist extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $customer;
    public $product;

    /**
     * Create a new message instance.
     *
     * @param $setting
     * @param $customer
     * @param $token
     */
    public function __construct($setting, $customer, $product)
    {
        $this->setting  = $setting;
        $this->customer = $customer;
        $this->product  = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.notify-customer-wishlist')
            ->subject('Stock Available: '.$this->product->name);
    }
}
