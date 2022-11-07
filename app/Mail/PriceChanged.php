<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class PriceChanged extends Mailable
{
    use Queueable, SerializesModels;

    public string $change_type;
    public int $change_value;
    public int $old_price;
    public Product $product;

    public function __construct(string $change_type, int $change_value, int $old_price, Product $product)
    {
        $this->change_type = $change_type;
        $this->change_value = $change_value;
        $this->product = $product;
        $this->old_price = $old_price;
    }

    public function build()
    {
        return $this->view('mail.price-change');
    }
}
