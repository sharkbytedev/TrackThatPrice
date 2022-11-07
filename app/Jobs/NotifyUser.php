<?php

namespace App\Jobs;

use App\Mail\PriceChanged;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;
    public string $change_type;
    public int $change_value;
    public int $old_price;
    public Product $product;

    public function __construct(User $user, string $change_type, int $change_value, int $old_price, Product $product)
    {
        $this->user = $user;
        $this->change_type = $change_type;
        $this->change_value = $change_value;
        $this->product = $product;
        $this->old_price = $old_price;
    }

    public function handle()
    {
        Mail::to($this->user)->send(new PriceChanged($this->change_type, $this->change_value, $this->old_price, $this->product));
    }
}
