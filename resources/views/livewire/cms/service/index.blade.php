<div class="max-w-5xl mx-auto p-6">
    <div class="mb-8">
        <livewire:cms.service.service-section-settings />
    </div>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Manage Services</h2>
        <a href="{{ route('cms.services.create') }}"
            class="bg-brand-accent hover:bg-brand-accent-light text-white px-4 py-2 rounded-md font-medium transition">
            + Add Service
        </a>
    </div>

    @if ($services->isEmpty())
        <div class="bg-white/[0.03] border border-white/10 rounded-lg p-8 text-center text-white/50">
            No services added yet.
        </div>
    @else
        <div class="space-y-3">
            @foreach ($services as $service)
                <div
                    class="flex justify-between items-center bg-white/[0.03] border border-white/10 rounded-lg p-4 hover:border-white/20 transition">
                    <div>
                        <h3 class="text-white font-medium">{{ $service->title }}</h3>
                        <p class="text-sm text-white/40">{{ $service->slug }}</p>
                        <p class="text-xs text-white/30 mt-1">{{ $service->items_count }} items</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('cms.services.edit', $service->id) }}"
                            class="text-brand-accent hover:text-brand-accent-light text-sm font-medium">Edit</a>
                        <button wire:click="delete({{ $service->id }})"
                            wire:confirm="Are you sure you want to delete this service? This will also delete all service items."
                            class="text-red-400 hover:text-red-300 text-sm font-medium">Delete</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div
            class="fixed bottom-4 right-4 bg-green-500/10 border border-green-500/30 text-green-300 px-4 py-3 rounded-lg shadow-lg z-50 animate-fade-in">
            {{ session('success') }}
        </div>
    @endif
</div>
