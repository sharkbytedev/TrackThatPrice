<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use \App\Models\Product;
use Illuminate\Http\Request;

class TrackerController extends Controller
{
    public function view(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);

        return view('view-tracker', ['product' => $product]);
    }

    public function new(Request $request){
        $product = new \App\Models\Product();
        $product->store = $request->post('store');
        $product->product_url = $request->post('productURL');

        $handler = \App\ProductHandlers\ProductHandlerFactory::new($product);
        $product_details = $handler::crawl($product);

        if ($product_details->name != null) {
            $product->product_name = $product_details->name;
        } else {
            $product->product_name = 'Product';
        }

        if ($product_details->image_url != null) {
            $product->image_url = $product_details->image_url;
        } else {
            $product->image_url = 'https://cdn.discordapp.com/attachments/620091571521454082/1027339673225396285/unknown.png'; //this is a placeholder
        }

        $product->price = $product_details->price;
        $product->save();
        $lastid = $product->id;
        Auth::user()->products()->attach($lastid);
        return view('trackers.new');
    }
}
