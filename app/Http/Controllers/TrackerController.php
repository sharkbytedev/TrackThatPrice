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

        $history = $product->history()->orderBy('created_at', 'desc')->get();
        $prices = [];
        $labels = [];
        foreach ($history as $datum) {
            array_push($prices, $datum->price);
            array_push($labels, $datum->created_at);
        }

        return view('view-tracker', ['product' => $product, 'prices'=>$prices, 'labels'=>$labels]);
    }
}
