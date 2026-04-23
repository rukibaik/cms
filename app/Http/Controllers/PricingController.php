<?php

namespace App\Http\Controllers;

use App\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PricingController extends Controller
{
    public function index()
    {
        return Pricing::with('benefits')->get();
    }

    public function update(Request $request, Pricing $pricing)
    {
        Gate::authorize('update', $pricing);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $pricing->update($validated);

        return response()->json([
            'message' => 'Paket harga berhasil diperbarui.',
            'data'    => $pricing->load('benefits'),
        ]);
    }
}
