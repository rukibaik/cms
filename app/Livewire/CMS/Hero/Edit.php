<?php

namespace App\Livewire\Cms\Hero;

use App\Models\HeroSection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

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
            'backgroundImage' => 'nullable|image|max:5120', // 5MB
        ]);

        $hero = HeroSection::getOrCreate();

        // Handle new image & cleanup old one
        if ($this->backgroundImage) {
            if ($this->preview) {
                Storage::disk('public')->delete($this->preview);
            }
            $validated['background_image'] = $this->backgroundImage->store('hero', 'public');
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
