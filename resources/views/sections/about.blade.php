<section class="relative bg-brand-darker py-24 lg:py-32 overflow-hidden">
    <!-- Subtle decorative glow -->
    <div
        class="absolute top-0 right-0 w-[600px] h-[600px] bg-brand-accent/[0.02] rounded-full blur-3xl pointer-events-none">
    </div>

    <div class="relative max-w-4xl mx-auto px-6 lg:px-8 text-center">
        @if ($about?->title)
            <h2
                class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight tracking-tight mb-4 text-white">
                {{ $about->title }}
            </h2>
        @endif

        @if ($about?->subtitle)
            <p class="text-brand-accent font-medium text-lg mb-8 tracking-wide">
                {{ $about->subtitle }}
            </p>
        @endif

        @if ($about?->description)
            <div class="max-w-2xl mx-auto">
                <p class="text-white/70 font-light leading-relaxed text-lg">
                    {{ $about->description }}
                </p>
            </div>
        @else
            <p class="text-white/40 italic max-w-lg mx-auto">Description has not been added yet.</p>
        @endif
    </div>
</section>
