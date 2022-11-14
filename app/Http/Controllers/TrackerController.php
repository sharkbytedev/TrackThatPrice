<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\UpdateProductData;

class TrackerController extends Controller
{
    public function view(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);

        return view('view-tracker', ['product' => $product]);
    }

    public function new(Request $request)
    {
        if($request->isMethod('get')){
            return view('trackers.new');
        }

        if($request->isMethod('post')){
            $product = new \App\Models\Product();
            $product->store = $request->post('store');
            
            $handler = \App\ProductHandlers\ProductHandlerFactory::new($product);

            if($product->store == "amazon"){
                $cutOffPoint = strpos($request->post('productURL'), "/dp/");
                $productCode = substr($request->post('productURL'), $cutOffPoint + 1, 13);
                $shortenedURL = (substr($request->post('productURL'), 0, $cutOffPoint)."/".$productCode);
                $product->product_url = $shortenedURL;
            }
            else{
                $product->product_url = $request->post('productURL');
            }
            $product->upc = null;

            $product->save();
            $lastid = $product->id;
            Auth::user()->products()->attach($lastid);
            UpdateProductData::dispatch($product);
            return view('trackers.new');
        }
    }
}