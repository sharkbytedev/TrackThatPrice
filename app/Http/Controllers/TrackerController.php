<?php

namespace App\Http\Controllers;

<<<<<<< feature/product-linking
use App\Models\Product;
=======
use DateTime;
use Illuminate\Http\Request;
>>>>>>> master
use Illuminate\Support\Facades\Auth;

class TrackerController extends Controller
{
    public function view(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);
<<<<<<< feature/product-linking
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

        return view('view-tracker', ['product' => $product, 'show_listings' => $show_listings]);
=======
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
>>>>>>> master
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

<<<<<<< feature/product-linking
    public function others(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $tracked_products = $user->products();
        $tracked = $tracked_products->get();
        $product = $tracked_products->findOrFail($product_id);

        $equivalents = Product::where('upc', $product->upc)
            ->whereNot('id', $product->id)
            ->get();
        abort_if($equivalents->count() <= 0, 404);

        $products = [];
        foreach ($equivalents as $product) {
            if (! array_key_exists($product->store, $products)) {
                $products[$product->store] = [];
            }
            $products[$product->store][] = $product;
        }

        return view('product-equivalents', ['products' => $products, 'tracked' => $tracked]);
    }

    public function quickTrack(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = Product::findOrFail($product_id);
        $user->products()->attach($product_id);

        return 200;
=======
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
>>>>>>> master
    }
}
