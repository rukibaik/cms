<?php

namespace App\Livewire\Cms\About;

use App\Models\AboutSection;
use Livewire\Component;

class Edit extends Component
{
    public ?string $title = null;
    public ?string $subtitle = null;
    public ?string $description = null;
    public bool $saving = false;

    public function mount(): void
    {
        $about = AboutSection::getOrCreate();
        $this->title = $about->title;
        $this->subtitle = $about->subtitle;
        $this->description = $about->description;
    }

    public function save(): void
    {
        $this->saving = true;

        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        AboutSection::getOrCreate()->update([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
        ]);

        session()->flash('success', 'About section updated successfully!');
        $this->saving = false;
    }

    public function render()
    {
        return view('livewire.cms.about.edit');
    }
}
