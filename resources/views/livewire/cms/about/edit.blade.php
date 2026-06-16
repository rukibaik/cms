<div class="max-w-3xl mx-auto p-6">
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        <div>
            <label for="title" class="block text-sm font-medium mb-1">Title</label>
            <input wire:model.live="title" type="text" id="title" placeholder="e.g., About Prestige In Media"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-3 focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="subtitle" class="block text-sm font-medium mb-1">Subtitle</label>
            <input wire:model.live="subtitle" type="text" id="subtitle"
                placeholder="e.g., Crafting Digital Excellence"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-3 focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('subtitle') border-red-500 @enderror">
            @error('subtitle')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium mb-1">Description</label>
            <textarea wire:model.live="description" id="description" rows="6"
                placeholder="Tell your story, mission, or values..."
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-3 focus:ring-2 focus:ring-brand-accent focus:border-transparent @error('description') border-red-500 @enderror"></textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end pt-2">
            <button wire:click="save" wire:loading.attr="disabled"
                class="bg-brand-accent hover:bg-brand-accent-light text-White px-6 py-2 rounded-md font-medium disabled:opacity-50 transition flex items-center gap-2">
                <span wire:loading.remove>Save Changes</span>
                <span wire:loading>
                    <svg class="animate-spin h-4 w-4 text-brand-dark" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Saving...
                </span>
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="mt-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-md flex items-center gap-2"
            role="alert">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
</div>
