<?php

namespace App\Livewire\Cms\Service;

use App\Models\Service;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    public ?Service $service = null;
    public ?string $title = null;
    public ?string $slug = null;
    public ?string $subtitle = null;
    public ?string $description = null;
    public bool $saving = false;

    public function mount(Service $service = null): void
    {
        $this->service = $service;
        if ($service) {
            $this->title = $service->title;
            $this->slug = $service->slug;
            $this->subtitle = $service->subtitle;
            $this->description = $service->description;
        }
    }

    public function updatedTitle(): void
    {
        if (!$this->service && $this->title) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save(): void
    {
        $this->saving = true;

        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:services,slug,' . ($this->service->id ?? 'NULL')],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
        ];

        if ($this->service) {
            $this->service->update($data);
        } else {
            $data['sort_order'] = Service::max('sort_order') + 1;
            Service::create($data);
        }

        session()->flash('success', $this->service ? 'Service updated successfully!' : 'Service created successfully!');
        $this->saving = false;

        redirect()->route('cms.services');
    }

    public function render()
    {
        return view('livewire.cms.service.form');
    }
}
