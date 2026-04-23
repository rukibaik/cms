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
        $hero = HeroSection::query()->first();
        $about = AboutSection::query()->first();
        $serviceSection = ServiceSectionSetting::query()->first();
        $services = Service::query()
            ->with('items.images')
            ->latest()
            ->get();
        $pricings = Pricing::query()
            ->with('benefits')
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
