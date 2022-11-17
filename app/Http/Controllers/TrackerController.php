<?php

namespace App\Http\Controllers;

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

    public function edit(Request $request, string $product_id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $product = $user->products()->findOrFail($product_id);
        $validated = $request->validate([
            'Tracker_name' => ['max:100', 'required'],
            'Compare_type' => ['regex:/^(flat|percent)$/', 'required'],
            'Compare_date' => ['date', 'required'],
            'Compare_value' => ['integer', 'required'],
        ]);

        $product->pivot->tracker_name = $request->input('Tracker_name');
        $product->pivot->type = $request->input('Compare_type');
        $product->pivot->compare_time = $request->input('Compare_date');
        $product->pivot->threshold = $request->input('Compare_value');
        $product->pivot->enabled = $request->input('Enabled') ? 1 : 0;
        $product->pivot->save();

        return redirect(route('trackers.view', ['product_id' => $product_id]));
    }
}
