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
            return view('dashboard.new');
        }

        if($request->isMethod('post')){
            $warnings = [];
            if(substr($request->post('productURL'), 0, 18) != "https://www.amazon"){
                if($request->post('store') == 'amazon'){
                    array_push($warnings, "Store provided does not match URL!");
                }
            }
            if(substr($request->post('productURL'), 0, 16) != "https://www.ebay"){
                if($request->post('store') == 'ebay'){
                    array_push($warnings, "Store provided does not match URL!");
                }
            }

            if(count($warnings) > 0){
                return view('dashboard.new', ['warnings' => (array)$warnings]);
            }

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

            $lastID = $product->id;
            Auth::user()->products()->attach($lastID);
            Auth::user()->products()->updateExistingPivot($lastID, ['tracker_name' => $request->post('trackerName')]);
            UpdateProductData::dispatch($product);
            return redirect(route('dashboard.view', ['product_id'=>$product->id]));
        }
    }
}
