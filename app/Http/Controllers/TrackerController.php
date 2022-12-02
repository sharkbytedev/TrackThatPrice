<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TrackerController extends Controller
{
    public function view(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);

        $h = $product->history()
            ->where('created_at', '<=', $product->pivot->compare_time)
            ->orderBy('created_at', 'desc')
            ->get()
            ->first();
        
        $target_price = null;
        if (isset($h)) {
            if ($product->pivot->type == 'flat') {
                $target_price = $h->price - $product->pivot->threshold;
            }
            else {
                $target_price = $h->price - ($h->price * ($product->pivot->threshold/100));
            }
        }

        return view('view-tracker', ['product' => $product, 'target_price'=>$target_price]);
    }
}
