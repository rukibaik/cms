@props(['hero'])

<section class="relative min-h-screen flex items-center justify-center text-center overflow-hidden">
    {{-- Background Image with Fallback --}}
    @if ($hero?->background_image)
        <img src="{{ asset('storage/' . $hero->background_image) }}" alt="{{ $hero->title }}"
            class="absolute inset-0 w-full h-full object-cover z-0" loading="eager" decoding="async">
    @else
        <div class="absolute inset-0 bg-brand-dark z-0"></div>
    @endif

    {{-- Dark Overlay for Readability --}}
    <div class="absolute inset-0 bg-brand-dark/70 z-10"></div>

    {{-- Content --}}
    <div class="relative z-20 max-w-4xl mx-auto px-6 animate-fade-in">
        <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight tracking-tight mb-6 text-white">
            {{ $hero?->title ?? 'Welcome to Our Agency' }}
        </h1>

        @if ($hero?->subtitle)
            <p class="text-lg sm:text-xl text-white/80 font-light max-w-2xl mx-auto mb-10">
                {{ $hero->subtitle }}
            </p>
        @endif

        @if ($hero?->button_text)
            <a href="{{ $hero->button_link ?: '#' }}"
                class="inline-block bg-brand-accent hover:bg-brand-accent-light text-brand-dark px-8 py-4 text-sm font-semibold tracking-wider uppercase rounded-sm transition-all duration-300 shadow-lg shadow-brand-accent/20 hover:shadow-brand-accent/30 hover:-translate-y-0.5">
                {{ $hero->button_text }}
            </a>
        @endif
    </div>
</section>
