<?php

namespace App\Livewire\Cms\Service;

use App\Models\Service;
use Livewire\Component;

class Index extends Component
{
    public function delete(int $id): void
    {
        Service::findOrFail($id)->delete();
        session()->flash('success', 'Service deleted successfully.');
    }

    public function render()
    {
        return view('livewire.cms.service.index', [
            'services' => Service::orderBy('sort_order')->get(),
        ]);
    }
}
