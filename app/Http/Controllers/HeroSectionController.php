<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\HeroSection;
use App\Support\OptimizedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'hero' => HeroSection::first(),
            'about' => AboutSection::first(),
        ]);
    }

    public function update(Request $request)
    {
        $hero = HeroSection::getOrCreate();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:max_width=3000,max_height=3000'],
        ]);

        if ($request->hasFile('background_image')) {
            $validated['background_image'] = OptimizedImage::storeHeroBackground($request->file('background_image'));

            if ($hero->background_image) {
                Storage::disk('public')->delete($hero->background_image);
            }
        }

        $hero->update($validated);

        return response()->json(['message' => 'Updated']);
    }
}
