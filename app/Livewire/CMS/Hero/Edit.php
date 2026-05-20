<?php

namespace App\Livewire\Cms\Hero;

use App\Models\HeroSection;
use App\Support\OptimizedImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    private const IMAGE_RULES = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:max_width=3000,max_height=3000'];

    public ?string $title = null;

    public ?string $subtitle = null;

    public ?string $buttonText = null;

    public ?string $buttonLink = null;

    public $backgroundImage = null;

    public ?string $preview = null;

    public bool $saving = false;

    public function mount(): void
    {
        $hero = HeroSection::getOrCreate();
        $this->title = $hero->title;
        $this->subtitle = $hero->subtitle;
        $this->buttonText = $hero->button_text;
        $this->buttonLink = $hero->button_link;
        $this->preview = $hero->background_image;
    }

    public function save(): void
    {
        $this->saving = true;

        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'buttonText' => 'nullable|string|max:100',
            'buttonLink' => 'nullable|url|max:255',
            'backgroundImage' => self::IMAGE_RULES,
        ]);

        $hero = HeroSection::getOrCreate();

        // Handle new image & cleanup old one
        if ($this->backgroundImage) {
            $validated['background_image'] = OptimizedImage::storeHeroBackground($this->backgroundImage);

            if ($this->preview) {
                Storage::disk('public')->delete($this->preview);
            }
        }

        $hero->update([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'button_text' => $this->buttonText,
            'button_link' => $this->buttonLink,
            'background_image' => $validated['background_image'] ?? $this->preview,
        ]);

        session()->flash('success', 'Hero section updated successfully!');
        $this->saving = false;
    }

    public function removeImage(): void
    {
        if ($this->preview) {
            Storage::disk('public')->delete($this->preview);
        }
        $this->backgroundImage = null;
        $this->preview = null;
        HeroSection::first()->update(['background_image' => null]);
        session()->flash('success', 'Background image removed.');
    }

    public function render()
    {
        return view('livewire.cms.hero.edit');
    }
}
