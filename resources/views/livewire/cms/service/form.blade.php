<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-white mb-6">{{ $service ? 'Edit' : 'Create' }} Service</h2>

    <div class="bg-white/[0.03] border border-white/10 rounded-lg p-6 space-y-5">
        <div>
            <label class="block text-sm font-medium text-white/70 mb-1">Title</label>
            <input wire:model.live.debounce.300ms="title" type="text"
                class="w-full bg-brand-dark border border-white/10 rounded-md p-3 text-white focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-white/70 mb-1">Slug</label>
            <input wire:model="slug" type="text"
                class="w-full bg-brand-dark border border-white/10 rounded-md p-3 text-white focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('slug') border-red-500 @enderror">
            @error('slug')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-white/70 mb-1">Subtitle</label>
            <input wire:model.live="subtitle" type="text"
                class="w-full bg-brand-dark border border-white/10 rounded-md p-3 text-white focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('subtitle') border-red-500 @enderror">
            @error('subtitle')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-white/70 mb-1">Description</label>
            <textarea wire:model.live="description" rows="5"
                class="w-full bg-brand-dark border border-white/10 rounded-md p-3 text-white focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('description') border-red-500 @enderror"></textarea>
            @error('description')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t border-white/10 pt-5 space-y-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-white">Service Items</h3>
                    <p class="text-sm text-white/50">Add the detail blocks shown on the service detail page.</p>
                </div>
                <button wire:click="addItem" type="button"
                    class="rounded-md border border-white/10 px-4 py-2 text-sm font-medium text-white/80 hover:bg-white/5 transition">
                    + Add Item
                </button>
            </div>

            @if (empty($items))
                <div class="rounded-lg border border-dashed border-white/10 p-6 text-center text-sm text-white/45">
                    No service items yet. Add one to build the detail page content.
                </div>
            @endif

            @foreach ($items as $index => $item)
                <div wire:key="service-item-{{ $index }}"
                    class="rounded-lg border border-white/10 bg-white/[0.02] p-5 space-y-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h4 class="text-base font-medium text-white">Item {{ $index + 1 }}</h4>
                            <p class="text-sm text-white/45">Each item supports one image, subtitle, and description.
                            </p>
                        </div>
                        <button wire:click="removeItem({{ $index }})" type="button"
                            class="text-sm font-medium text-red-400 hover:text-red-300 transition">
                            Remove
                        </button>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-white/70 mb-1">Item Title</label>
                            <input wire:model.live="items.{{ $index }}.title" type="text"
                                class="w-full bg-brand-dark border border-white/10 rounded-md p-3 text-white focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('items.' . $index . '.title') border-red-500 @enderror">
                            @error('items.' . $index . '.title')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white/70 mb-1">Item Subtitle</label>
                            <input wire:model.live="items.{{ $index }}.subtitle" type="text"
                                class="w-full bg-brand-dark border border-white/10 rounded-md p-3 text-white focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('items.' . $index . '.subtitle') border-red-500 @enderror">
                            @error('items.' . $index . '.subtitle')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Item Description</label>
                        <textarea wire:model.live="items.{{ $index }}.description" rows="4"
                            class="w-full bg-brand-dark border border-white/10 rounded-md p-3 text-white focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('items.' . $index . '.description') border-red-500 @enderror"></textarea>
                        @error('items.' . $index . '.description')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Image</label>
                        <input wire:model.live="itemImages.{{ $index }}" type="file" accept="image/jpeg,image/png,image/webp"
                            class="w-full bg-brand-dark border border-white/10 rounded-md p-3 text-white focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('itemImages.' . $index) border-red-500 @enderror">
                        <p class="mt-1 text-xs text-white/45">
                            JPG, PNG, or WebP only. Max 2 MB and 3000 x 3000 px. Saved as optimized WebP.
                        </p>
                        @error('itemImages.' . $index)
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if (!empty($itemImages[$index]))
                        <div class="relative overflow-hidden rounded-lg border border-white/10">
                            <img src="{{ $itemImages[$index]->temporaryUrl() }}" alt="Preview"
                                class="h-48 w-full object-cover">
                            <button wire:click="removeItemImage({{ $index }})" type="button"
                                class="absolute right-3 top-3 rounded bg-black/70 px-3 py-1 text-xs font-medium text-white">
                                Remove image
                            </button>
                        </div>
                    @elseif (!empty($item['image']))
                        <div class="relative overflow-hidden rounded-lg border border-white/10">
                            <img src="{{ asset('storage/' . $item['image']) }}"
                                alt="{{ $item['title'] ?: 'Item image' }}" class="h-48 w-full object-cover">
                            <button wire:click="removeItemImage({{ $index }})" type="button"
                                class="absolute right-3 top-3 rounded bg-black/70 px-3 py-1 text-xs font-medium text-white">
                                Remove image
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('cms.services') }}"
                class="px-4 py-2 border border-white/10 text-white/70 rounded-md hover:bg-white/5 transition">Cancel</a>
            <button wire:click="save" wire:loading.attr="disabled"
                class="bg-brand-accent hover:bg-brand-accent-light text-white px-6 py-2 rounded-md font-medium disabled:opacity-50 transition flex items-center gap-2">
                <span wire:loading.remove>Save</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </div>

</div>
