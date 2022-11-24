<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class TrackerController extends Controller
{
    public function view(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);
        $show_listings = false;
        // Find product from other stores
        if (isset($product->upc)) {
            $equivalents = Product::where('upc', $product->upc)
            ->whereNot('id', $product->id)
            ->get();
            if ($equivalents->count() > 0) {
                $show_listings = true;
            }
        }

        return view('view-tracker', ['product' => $product, 'show_listings'=>$show_listings]);
    }

    public function remove(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);

        return view('delete-tracker', ['product' => $product]);
    }

    public function delete(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);
        $user->products()->detach($product->product_id);

        return redirect('/dashboard');
    }

    public function others(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);

        $equivalents = Product::where('upc', $product->upc)
            ->whereNot('id', $product->id)
            ->get();
        abort_if($equivalents->count() <= 0, 404);

        $products = [];
        foreach ($equivalents as $product) {
            if (!array_key_exists($product->store, $products)) {
                $products[$product->store] = [];
            }
            $products[$product->store][] = $product;
        }

        return view('product-equivalents', ['products'=>$products]);
    }
}
