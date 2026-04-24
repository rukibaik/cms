<div class="rounded-lg border border-white/10 bg-white/[0.03] p-6 space-y-5">
    <div>
        <h2 class="text-xl font-bold text-white">Service Section Settings</h2>
        <p class="mt-1 text-sm text-white/50">Update the heading and CTA shown on the public services section.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium text-white/70">Section Title</label>
            <input wire:model.live="title" type="text"
                class="w-full rounded-md border border-white/10 bg-brand-dark p-3 text-white focus:border-transparent focus:ring-2 focus:ring-brand-accent @error('title') border-red-500 @enderror">
            @error('title')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-white/70">Button Text</label>
            <input wire:model.live="buttonText" type="text"
                class="w-full rounded-md border border-white/10 bg-brand-dark p-3 text-white focus:border-transparent focus:ring-2 focus:ring-brand-accent @error('buttonText') border-red-500 @enderror">
            @error('buttonText')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-white/70">Section Subtitle</label>
        <textarea wire:model.live="subtitle" rows="3"
            class="w-full rounded-md border border-white/10 bg-brand-dark p-3 text-white focus:border-transparent focus:ring-2 focus:ring-brand-accent @error('subtitle') border-red-500 @enderror"></textarea>
        @error('subtitle')
            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-white/70">Button Link</label>
        <input wire:model.live="buttonLink" type="url" placeholder="https://example.com"
            class="w-full rounded-md border border-white/10 bg-brand-dark p-3 text-white focus:border-transparent focus:ring-2 focus:ring-brand-accent @error('buttonLink') border-red-500 @enderror">
        @error('buttonLink')
            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <button wire:click="save" wire:loading.attr="disabled"
            class="rounded-md bg-brand-accent px-6 py-2 font-medium text-brand-dark transition hover:bg-brand-accent-light disabled:opacity-50">
            <span wire:loading.remove>Save Settings</span>
            <span wire:loading>Saving...</span>
        </button>
    </div>

    @if (session('success'))
        <div class="rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif
</div>
