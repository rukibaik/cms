<?php

namespace App\Livewire\Cms;

use App\Models\ServiceSectionSetting;
use Livewire\Component;

class ServiceSectionSettings extends Component
{
    public ?string $title = null;
    public ?string $subtitle = null;
    public ?string $buttonText = null;
    public ?string $buttonLink = null;
    public bool $saving = false;

    public function mount(): void
    {
        $setting = ServiceSectionSetting::getOrCreate();
        $this->title = $setting->title;
        $this->subtitle = $setting->subtitle;
        $this->buttonText = $setting->button_text;
        $this->buttonLink = $setting->button_link;
    }

    public function save(): void
    {
        $this->saving = true;
        $this->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'buttonText' => 'nullable|string|max:100',
            'buttonLink' => 'nullable|url|max:255',
        ]);

        ServiceSectionSetting::getOrCreate()->update([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'button_text' => $this->buttonText,
            'button_link' => $this->buttonLink,
        ]);

        session()->flash('success', 'Section settings saved!');
        $this->saving = false;
    }

    public function render()
    {
        return view('livewire.cms.service-section-settings');
    }
}
