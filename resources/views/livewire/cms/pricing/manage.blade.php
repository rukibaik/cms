{{-- resources/views/livewire/cms/pricing/manage.blade.php --}}
<div class="space-y-8 p-6">
    @foreach ($pricings as $index => $pricing)
        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 bg-white dark:bg-gray-800 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Plan {{ $index + 1 }}</h3>
                <button wire:click="removePricing({{ $index }})"
                    class="text-red-500 hover:text-red-700 text-sm">Remove</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input wire:model.live="pricings.{{ $index }}.name" type="text"
                        class="w-full border rounded p-2 @error('pricings.' . $index . '.name') border-red-500 @enderror">
                    @error('pricings.' . $index . '.name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Price</label>
                    <input wire:model.live="pricings.{{ $index }}.price" type="number" step="0.01"
                        class="w-full border rounded p-2 @error('pricings.' . $index . '.price') border-red-500 @enderror">
                    @error('pricings.' . $index . '.price')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Button Text</label>
                    <input wire:model.live="pricings.{{ $index }}.button_text" type="text"
                        class="w-full border rounded p-2 @error('pricings.' . $index . '.button_text') border-red-500 @enderror">
                    @error('pricings.' . $index . '.button_text')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Button Link</label>
                    <input wire:model.live="pricings.{{ $index }}.button_link" type="text"
                        placeholder="# or /contact or https://..."
                        class="w-full border rounded p-2 @error('pricings.' . $index . '.button_link') border-red-500 @enderror">
                    @error('pricings.' . $index . '.button_link')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea wire:model.live="pricings.{{ $index }}.description" rows="2"
                        class="w-full border rounded p-2 @error('pricings.' . $index . '.description') border-red-500 @enderror"></textarea>
                    @error('pricings.' . $index . '.description')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2 flex items-center gap-2">
                    <input wire:model.live="pricings.{{ $index }}.is_featured" type="checkbox"
                        class="rounded text-brand-accent">
                    <label class="text-sm">Featured Plan</label>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium mb-2">Benefits</label>
                @foreach ($pricing['benefits'] as $bIndex => $benefit)
                    <div class="mb-2 flex gap-2" wire:key="benefit-{{ $index }}-{{ $bIndex }}">
                        <input wire:model.live="pricings.{{ $index }}.benefits.{{ $bIndex }}" type="text"
                            class="flex-1 border rounded p-2 @error('pricings.' . $index . '.benefits.' . $bIndex) border-red-500 @enderror">
                        <button wire:click="removeBenefit({{ $index }}, {{ $bIndex }})"
                            class="px-2 text-red-500 hover:text-red-700">&times;</button>
                    </div>
                    @error('pricings.' . $index . '.benefits.' . $bIndex)
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                @endforeach
                <button wire:click="addBenefit({{ $index }})"
                    class="mt-1 text-sm text-blue-500 hover:underline">+ Add Benefit</button>
            </div>
        </div>
    @endforeach

    <div class="flex justify-between items-center pt-4 border-t">
        <button wire:click="addPricing" class="bg-gray-200 hover:bg-gray-300 text-brand-accent px-4 py-2 rounded">+ Add
            Plan</button>
        <button wire:click="save" wire:loading.attr="disabled"
            class="bg-brand-accent hover:bg-brand-accent-light text-white px-6 py-2 rounded disabled:opacity-50 font-medium">
            <span wire:loading.remove>Save All</span>
            <span wire:loading>Saving...</span>
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mt-4">{{ session('success') }}</div>
    @endif
</div>
