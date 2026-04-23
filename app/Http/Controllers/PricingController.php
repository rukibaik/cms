<?php

namespace App\Http\Controllers;

use App\Models\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        return Pricing::with('benefits')->get();
    }

    public function update(Request $request, Pricing $pricing)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'button_text' => 'nullable',
            'button_link' => 'nullable|url',
            'description' => 'nullable',
        ]);

        $pricing->update($data);

        return $pricing;
    }
}
