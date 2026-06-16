@props(['hero'])

@php
    $heroTitle = $hero?->title
        ? str($hero->title)
            ->replace('Naik Level', '<span class="text-white">Naik Level</span>')
            ->replace('Kreatif', '<span class="text-white">Kreatif</span>')
            ->replace('Media', '<span class="font-normal italic text-white">Media</span>')
        : 'Welcome to Our Agency';
    $heroImageSrcset ??= \App\Support\OptimizedImage::srcset($hero?->background_image);
@endphp

<section
    class="relative flex min-h-[100svh] items-center overflow-hidden bg-whitept-16 lg:pt-20"
    id="home"
>
    @if ($hero?->background_image)
        <img
            class="absolute inset-0 h-full w-full object-cover opacity-70"
            src="{{ asset('storage/' . $hero->background_image) }}"
            @if ($heroImageSrcset) srcset="{{ $heroImageSrcset }}" sizes="100vw" @endif
            alt=""
            width="1920"
            height="1080"
            loading="eager"
            decoding="async"
            fetchpriority="high"
        >
    @endif

    <div class="absolute inset-0 bg-white/10 from-brand-darker/65 via-black/45 to-brand-darker/80"></div>
    <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-brand-darker/95 to-transparent pointer-events-none"></div>

    <div class="relative z-20 mx-auto w-full max-w-6xl px-5 pt-10 pb-20 text-center sm:px-6 sm:py-24 lg:px-8 lg:py-28">
        <p class="mb-5 text-xs font-semibold uppercase tracking-[0.22em] text-white/90 sm:text-sm sm:tracking-[0.28em]">
            Prestige In Media
        </p>

        <h1 class="mx-auto max-w-5xl text-5xl font-bold leading-[1.04] tracking-tight text-white text-balance sm:text-6xl lg:text-7xl">
            {!! $heroTitle !!}
        </h1>

        @if ($hero?->subtitle)
            <p class="mx-auto mt-6 max-w-md text-base leading-relaxed text-white/76 text-pretty sm:mt-6 sm:text-md">
                {{ $hero->subtitle }}
            </p>
        @endif

        @if ($hero?->button_text)
            <div class="mx-auto mt-10 flex w-full max-w-xl flex-col items-stretch justify-center gap-3 sm:mt-12 sm:flex-row sm:items-center sm:gap-4">
                <a
                    class="btn btn-primary"
                    href="{{ $hero->button_link ?: route('home') . '#contact' }}"
                >
                    {{ $hero->button_text }}
                </a>
                <a
                    class="btn btn-secondary"
                    href="{{ route('home') }}#services"
                >
                    Lihat Layanan
                </a>
            </div>
        @endif

        <div class="mx-auto mt-12 max-w-3xl sm:mt-16">
            <div class="flex flex-wrap items-center justify-center gap-x-3 gap-y-2 rounded-md border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/72 sm:text-base">
                <span>Design</span>
                <span class="text-brand-accent" aria-hidden="true">&middot;</span>
                <span>Visual Photo</span>
                <span class="text-brand-accent" aria-hidden="true">&middot;</span>
                <span>Social Media Management</span>
                <span class="text-brand-accent" aria-hidden="true">&middot;</span>
                <span>Video Production</span>
            </div>
        </div>
    </div>
</section>
