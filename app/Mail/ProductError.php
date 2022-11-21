<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductError extends Mailable
{
    use Queueable, SerializesModels;

    public Product $product;

    public string $error;

    public function __construct(Product $product, string $error)
    {
        $this->product = $product;
        $this->error = $error;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.product-error', ['error' => $this->error, 'product' => $this->product])->subject('There was an issue with a product you\'re tracking');
    }
}
