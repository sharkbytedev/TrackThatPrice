<?php

namespace App\Http\Controllers;


use DateTime;
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

    public function update(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);

        return view('update-tracker', ['tracker' => $product->pivot]);
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
        $user->products()->detach($product->id);

        return redirect('/dashboard');
    }

    public function edit(Request $request, string $product_id)
    {
        $validated = $request->validate([
            'Tracker_name' => ['max:100', 'required'],
            'Compare_type' => ['regex:/^(flat|percent)$/', 'required'],
            'Compare_date' => ['date', 'required', 'after:1970-01-01 00:00:01.000000', 'before:2038-01-19 03:14:07.999999'],
            'Compare_value' => ['integer', 'required', 'between:1,2147483647'],
        ]);

        $product->pivot->tracker_name = $request->input('Tracker_name');
        $product->pivot->type = $request->input('Compare_type');
        $product->pivot->compare_time = DateTime::createFromFormat('Y-m-d', $request->input('Compare_date'))->format('Y-m-d H:i:s');
        $product->pivot->threshold = $request->input('Compare_value');
        $product->pivot->enabled = $request->input('Enabled') ? 1 : 0;
        $product->pivot->save();

        return redirect(route('trackers.view', ['product_id' => $product_id]));
    }

    public function new(Request $request)
    {
        if($request->isMethod('get')){
            return view('trackers.new');
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
                return view('trackers.new', ['warnings' => (array)$warnings]);
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
            return redirect(route('trackers.view', ['product_id'=>$product->id]));
        }
    }

    public function archive(string $id)
    {
        $products = Auth::user()->products()->get();
        $product = $products->find($id);
        $product->pivot->archived = true;
        $product->pivot->save();
        return view('dashboard', ['products' => $products]);
    }

    public function unarchive(string $id)
    {
        $products = Auth::user()->products()->get();
        $product = $products->find($id);
        $product->pivot->archived = false;
        $product->pivot->save();
        return view('trackers/archived', ['products' => $products]);
    }
}
