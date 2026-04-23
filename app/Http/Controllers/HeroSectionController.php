<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function index()
    {
        return HeroSection::first();
    }

    public function update(Request $request)
    {
        $hero = HeroSection::first();

        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'button_text' => 'nullable',
            'button_link' => 'nullable|url',
            'background_image' => 'nullable|image',
        ]);

        if ($request->hasFile('background_image')) {
            $validated['background_image'] = $request->file('background_image')->store('hero');
        }

        $hero->update($validated);

        return response()->json(['message' => 'Updated']);
    }
}
