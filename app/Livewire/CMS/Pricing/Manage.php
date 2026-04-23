<?php

// app/Livewire/Cms/Pricing/Manage.php
namespace App\Livewire\Cms\Pricing;

use App\Models\Pricing;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Manage extends Component
{
    public array $pricings = [];
    public bool $saving = false;

    public function mount(): void
    {
        $this->pricings = Pricing::with('benefits')->orderBy('sort_order')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
                'button_text' => $p->button_text,
                'button_link' => $p->button_link,
                'description' => $p->description,
                'is_featured' => $p->is_featured,
                'sort_order' => $p->sort_order,
                'benefits' => $p->benefits->pluck('benefit')->toArray(),
            ];
        })->toArray();

        if (empty($this->pricings)) {
            $this->pricings = [
                ['id' => null, 'name' => 'Basic', 'price' => 0, 'button_text' => 'Get Started', 'button_link' => '#', 'description' => '', 'is_featured' => false, 'sort_order' => 0, 'benefits' => []],
                ['id' => null, 'name' => 'Pro', 'price' => 0, 'button_text' => 'Get Started', 'button_link' => '#', 'description' => '', 'is_featured' => true, 'sort_order' => 1, 'benefits' => []],
                ['id' => null, 'name' => 'Enterprise', 'price' => 0, 'button_text' => 'Contact Sales', 'button_link' => '#', 'description' => '', 'is_featured' => false, 'sort_order' => 2, 'benefits' => []],
            ];
        }
    }

    public function addPricing(): void
    {
        $this->pricings[] = [
            'id' => null,
            'name' => 'New Plan',
            'price' => 0,
            'button_text' => 'Get Started',
            'button_link' => '#',
            'description' => '',
            'is_featured' => false,
            'sort_order' => count($this->pricings),
            'benefits' => []
        ];
    }

    public function removePricing(int $index): void
    {
        unset($this->pricings[$index]);
        $this->pricings = array_values($this->pricings);
    }

    public function addBenefit(int $index): void
    {
        $this->pricings[$index]['benefits'][] = '';
    }

    public function removeBenefit(int $pricingIndex, int $benefitIndex): void
    {
        unset($this->pricings[$pricingIndex]['benefits'][$benefitIndex]);
        $this->pricings[$pricingIndex]['benefits'] = array_values($this->pricings[$pricingIndex]['benefits']);
    }

    public function save(): void
    {
        $this->saving = true;

        $this->validate([
            'pricings.*.name' => 'required|string|max:255',
            'pricings.*.price' => 'required|numeric|min:0',
            'pricings.*.button_text' => 'nullable|string|max:255',
            'pricings.*.button_link' => 'nullable|url|max:255',
            'pricings.*.description' => 'nullable|string',
            'pricings.*.benefits.*' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () {
            foreach ($this->pricings as $index => $data) {
                $pricing = $data['id'] ? Pricing::find($data['id']) : new Pricing();
                $pricing->fill([
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'button_text' => $data['button_text'],
                    'button_link' => $data['button_link'],
                    'description' => $data['description'],
                    'is_featured' => $data['is_featured'],
                    'sort_order' => $index,
                ]);
                $pricing->save();

                $benefitTexts = array_filter($data['benefits'], fn($b) => trim($b) !== '');
                $pricing->benefits()->delete();
                foreach ($benefitTexts as $order => $text) {
                    $pricing->benefits()->create(['benefit' => trim($text), 'sort_order' => $order]);
                }
            }
        });

        session()->flash('success', 'Pricing plans saved successfully!');
        $this->saving = false;
    }

    public function render()
    {
        return view('livewire.cms.pricing.manage');
    }
}
