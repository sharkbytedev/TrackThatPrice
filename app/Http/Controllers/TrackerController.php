<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackerController extends Controller
{
    public function view(string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);

        return view('view-tracker', ['product' => $product]);
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
        $user->products()->detach($product->product_id);

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
}
