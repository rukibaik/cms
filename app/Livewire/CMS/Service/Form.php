<?php

namespace App\Livewire\Cms\Service;

use App\Models\Service;
use App\Support\OptimizedImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    private const IMAGE_RULES = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:max_width=3000,max_height=3000'];

    public ?Service $service = null;

    public ?string $title = null;

    public ?string $slug = null;

    public ?string $subtitle = null;

    public ?string $description = null;

    public array $items = [];

    public array $itemImages = [];

    public bool $saving = false;

    public function mount(?Service $service = null): void
    {
        $this->service = $service;
        if ($service) {
            $this->title = $service->title;
            $this->slug = $service->slug;
            $this->subtitle = $service->subtitle;
            $this->description = $service->description;
            $this->items = $service->items
                ->map(fn ($item) => [
                    'id' => $item->id,
                    'title' => $item->title,
                    'subtitle' => $item->subtitle,
                    'description' => $item->description,
                    'image' => $item->image,
                    'existing_image' => $item->image,
                    'remove_image' => false,
                ])
                ->toArray();
        }
    }

    public function updatedTitle(): void
    {
        if (! $this->service && $this->title) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function addItem(): void
    {
        $this->items[] = $this->emptyItem();
    }

    public function removeItem(int $index): void
    {
        unset($this->items[$index], $this->itemImages[$index]);

        $this->items = array_values($this->items);
        $this->itemImages = array_values($this->itemImages);
    }

    public function removeItemImage(int $index): void
    {
        unset($this->itemImages[$index]);

        if (! isset($this->items[$index])) {
            $this->itemImages = array_values($this->itemImages);

            return;
        }

        $this->items[$index]['image'] = null;
        $this->items[$index]['remove_image'] = true;
        $this->itemImages = array_values($this->itemImages);
    }

    public function save(): void
    {
        $this->saving = true;
        $isEditing = $this->service !== null;

        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($this->service?->id),
            ],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'items.*.title' => ['required', 'string', 'max:255'],
            'items.*.subtitle' => ['nullable', 'string', 'max:255'],
            'items.*.description' => ['nullable', 'string'],
            'itemImages.*' => self::IMAGE_RULES,
        ]);

        DB::transaction(function (): void {
            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'subtitle' => $this->subtitle,
                'description' => $this->description,
            ];

            if ($this->service) {
                $this->service->update($data);
            } else {
                $data['sort_order'] = (Service::max('sort_order') ?? -1) + 1;
                $this->service = Service::create($data);
            }

            $keptItemIds = [];

            foreach ($this->items as $index => $itemData) {
                $item = $this->service->items()->find($itemData['id'] ?? null) ?? $this->service->items()->make();
                $imagePath = $itemData['existing_image'] ?? null;

                if (! empty($itemData['remove_image']) && $itemData['existing_image']) {
                    OptimizedImage::delete($itemData['existing_image']);
                    $imagePath = null;
                }

                if (! empty($this->itemImages[$index])) {
                    $imagePath = OptimizedImage::storeServiceItem($this->itemImages[$index]);

                    if ($itemData['existing_image']) {
                        OptimizedImage::delete($itemData['existing_image']);
                    }
                }

                $item->fill([
                    'title' => $itemData['title'],
                    'subtitle' => $itemData['subtitle'],
                    'description' => $itemData['description'],
                    'image' => $imagePath,
                    'sort_order' => $index,
                ]);
                $item->service()->associate($this->service);
                $item->save();

                $keptItemIds[] = $item->id;
            }

            $itemsToDelete = $this->service->items()
                ->when($keptItemIds !== [], fn ($query) => $query->whereNotIn('id', $keptItemIds))
                ->when($keptItemIds === [], fn ($query) => $query)
                ->get();

            foreach ($itemsToDelete as $item) {
                if ($item->image) {
                    OptimizedImage::delete($item->image);
                }

                $item->delete();
            }
        });

        session()->flash('success', $isEditing ? 'Service updated successfully!' : 'Service created successfully!');
        $this->saving = false;

        redirect()->route('cms.services');
    }

    public function render()
    {
        return view('livewire.cms.service.form');
    }

    protected function emptyItem(): array
    {
        return [
            'id' => null,
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'image' => null,
            'existing_image' => null,
            'remove_image' => false,
        ];
    }
}
