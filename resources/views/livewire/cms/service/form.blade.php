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

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('cms.services') }}"
                class="px-4 py-2 border border-white/10 text-white/70 rounded-md hover:bg-white/5 transition">Cancel</a>
            <button wire:click="save" wire:loading.attr="disabled"
                class="bg-brand-accent hover:bg-brand-accent-light text-brand-dark px-6 py-2 rounded-md font-medium disabled:opacity-50 transition flex items-center gap-2">
                <span wire:loading.remove>Save</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </div>
</div>
