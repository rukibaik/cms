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
            'pricings.*.button_link' => 'nullable|string|max:255',
            'pricings.*.description' => 'nullable|string',
            'pricings.*.benefits.*' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () {
            $keptPricingIds = [];

            foreach ($this->pricings as $index => $data) {
                $pricing = $data['id'] ? Pricing::find($data['id']) : new Pricing();
                $pricing->fill([
                    'name' => trim($data['name']),
                    'price' => $data['price'],
                    'button_text' => $this->nullableString($data['button_text'] ?? null),
                    'button_link' => $this->normalizeLink($data['button_link'] ?? null),
                    'description' => $this->nullableString($data['description'] ?? null),
                    'is_featured' => (bool) ($data['is_featured'] ?? false),
                    'sort_order' => $index,
                ]);
                $pricing->save();
                $keptPricingIds[] = $pricing->id;

                $benefitTexts = array_filter($data['benefits'], fn($b) => trim($b) !== '');
                $pricing->benefits()->delete();
                foreach ($benefitTexts as $order => $text) {
                    $pricing->benefits()->create(['benefit' => trim($text), 'sort_order' => $order]);
                }
            }

            Pricing::query()
                ->when($keptPricingIds !== [], fn($query) => $query->whereNotIn('id', $keptPricingIds))
                ->when($keptPricingIds === [], fn($query) => $query)
                ->delete();
        });

        session()->flash('success', 'Pricing plans saved successfully!');
        $this->saving = false;
    }

    public function render()
    {
        return view('livewire.cms.pricing.manage');
    }

    protected function nullableString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    protected function normalizeLink(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
