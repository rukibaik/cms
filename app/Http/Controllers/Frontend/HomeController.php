<?php

namespace App\Http\Controllers\Frontend;

use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Pricing;
use App\Models\Service;
use App\Models\ServiceSectionSetting;

class HomeController
{
    public function index()
    {
        $hero = HeroSection::query()
            ->select(['id', 'title', 'subtitle', 'button_text', 'button_link', 'background_image'])
            ->first();
        $about = AboutSection::query()
            ->select(['id', 'subtitle', 'title', 'description'])
            ->first();
        $serviceSection = ServiceSectionSetting::getOrCreate();
        $services = Service::query()
            ->select(['id', 'title', 'slug', 'subtitle', 'sort_order'])
            ->withCount('items')
            ->orderBy('sort_order')
            ->get();
        $pricings = Pricing::query()
            ->select(['id', 'name', 'price', 'button_text', 'button_link', 'description', 'is_featured'])
            ->with(['benefits:id,pricing_id,benefit,sort_order'])
            ->orderBy('price')
            ->get();

        return view('pages.home', [
            'hero' => $hero,
            'about' => $about,
            'serviceSection' => $serviceSection,
            'services' => $services,
            'pricings' => $pricings,
        ]);
    }
}
