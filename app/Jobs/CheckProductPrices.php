<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckProductPrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle()
    {
        $users = $this->product->users()->wherePivot('enabled', 1)->get();
        foreach ($users as $user) {
            // Get the price closest to the compare time
            /** @var int */
            $h = $this->product->history()
                ->where('created_at', '<=', $user->pivot->compare_time)
                ->orderBy('created_at', 'desc')
                ->get()
                ->first();
            if (isset($h)) {
                $last_price = $h->price;
            } else {
                // No data for before the compare time
                continue;
            }

            if ($user->pivot->type === 'flat') {
                if ($last_price - $this->product->price >= $user->pivot->threshold) {
                    NotifyUser::dispatch($user, 'flat', $last_price - $this->product->price, $last_price, $this->product);
                }
            } elseif ($user->pivot->type === 'percent') {
                $dropped_percent = (($last_price - $this->product->price) / $last_price) * 100.0;
                if ($dropped_percent >= $user->pivot->threshold) {
                    NotifyUser::dispatch($user, 'percent', $dropped_percent, $last_price, $this->product);
                }
            }
        }
    }
}
