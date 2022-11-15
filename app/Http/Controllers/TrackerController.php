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
        $target = null;
        if (isset($product->pivot->type) and isset($product->pivot->threshold) and isset($product->pivot->compare_time)) {
            $target = ['threshold' => $product->pivot->threshold, 'type' => $product->pivot->type, 'compare_time' => $product->pivot->compare_time];
        }
        $history = $product->history()->orderBy('created_at', 'desc')->get();
        $prices = [];
        $labels = [];
        foreach ($history as $datum) {
            array_push($prices, $datum->price);
            array_push($labels, $datum->created_at);
        }

        return view('view-tracker', ['product' => $product, 'prices' => $prices, 'labels' => $labels, 'target' => $target]);
    }
}
