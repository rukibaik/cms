<?php

namespace App\Livewire\Cms\Service;

use App\Models\Service;
use App\Support\OptimizedImage;
use Livewire\Component;

class Index extends Component
{
    public function delete(int $id): void
    {
        $service = Service::with('items')->findOrFail($id);

        foreach ($service->items as $item) {
            if ($item->image) {
                OptimizedImage::delete($item->image);
            }
        }

        $service->delete();
        session()->flash('success', 'Service deleted successfully.');
    }

    public function render()
    {
        return view('livewire.cms.service.index', [
            'services' => Service::withCount('items')->orderBy('sort_order')->get(),
        ]);
    }
}
