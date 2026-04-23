<?php

namespace App\Livewire;

use App\Models\Pricing;
use App\Models\Service;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'serviceCount' => Service::query()->count(),
            'pricingCount' => Pricing::query()->count(),
        ]);
    }
}
