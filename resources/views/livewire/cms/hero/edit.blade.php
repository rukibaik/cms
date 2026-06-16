<div class="max-w-2xl mx-auto p-6 space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-4">
        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input wire:model.live="title" type="text"
                class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 @error('title') border-red-500 @enderror">
            @error('title')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Subtitle</label>
            <textarea wire:model.live="subtitle" rows="2"
                class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 @error('subtitle') border-red-500 @enderror"></textarea>
            @error('subtitle')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Button Text</label>
                <input wire:model.live="buttonText" type="text"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 @error('buttonText') border-red-500 @enderror">
                @error('buttonText')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Button Link</label>
                <input wire:model.live="buttonLink" type="url" placeholder="https://..."
                    class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 @error('buttonLink') border-red-500 @enderror">
                @error('buttonLink')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Background Image</label>
            <input wire:model.live="backgroundImage" type="file" accept="image/jpeg,image/png,image/webp"
                class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 @error('backgroundImage') border-red-500 @enderror">
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                JPG, PNG, or WebP only. Max 2 MB and 3000 x 3000 px. Saved as optimized WebP.
            </p>
            @error('backgroundImage')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        {{-- Image Preview / Existing --}}
        @if ($backgroundImage)
            <div class="relative group">
                <img src="{{ $backgroundImage->temporaryUrl() }}" class="h-48 w-full object-cover rounded"
                    alt="Preview">
                <div
                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                    <span class="text-white text-sm">New Upload</span>
                </div>
            </div>
        @elseif ($preview)
            <div class="relative group">
                <img src="{{ asset('storage/' . $preview) }}" class="h-48 w-full object-cover rounded" alt="Current">
                <button wire:click="removeImage" type="button"
                    class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition">Remove</button>
            </div>
        @else
            <div
                class="h-48 w-full bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center text-gray-400 text-sm">
                No image uploaded
            </div>
        @endif

        <div class="flex justify-end pt-4">
            <button wire:click="save" wire:loading.attr="disabled"
                class="bg-brand-accent hover:bg-brand-accent-light text-white px-6 py-2 rounded font-medium disabled:opacity-50 transition">
                <span wire:loading.remove>Save Changes</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('success') }}
        </div>
    @endif
</div>
