@extends('layouts.guest')

@section('content')
    <section class="min-h-[100svh] bg-brand-darker pb-20 pt-28 lg:pb-24 lg:pt-36">
        <div class="mx-auto max-w-6xl px-5 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}#services"
                class="mb-8 inline-flex min-h-11 items-center gap-2 rounded-md text-sm font-semibold text-brand-accent transition-colors duration-150 hover:text-brand-accent-light focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Services
            </a>

            <div class="mt-6 border-b border-white/10 pb-8">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs uppercase tracking-[0.2em] text-brand-accent">Service Detail</p>
                    <a href="https://www.instagram.com/prestigeworkpage/" target="_blank" rel="noopener noreferrer" class="btn btn-outline">
                        Visit Instagram
                    </a>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-white text-balance sm:text-4xl lg:text-5xl">
                    {{ $service->title }}</h1>
                @if ($service->subtitle)
                    <p class="mt-3 max-w-3xl text-lg text-white/65 text-pretty">{{ $service->subtitle }}</p>
                @endif
                @if ($service->description)
                    <div class="mt-6 max-w-3xl text-white/70 leading-relaxed">{{ $service->description }}</div>
                @endif
            </div>

            <div class="mt-12 space-y-10">
                @forelse ($service->items as $item)
                    <article class="scroll-mt-32">
                        @if ($item->subtitle)
                            <p class="text-xs uppercase tracking-[0.2em] text-brand-accent mb-2">{{ $item->subtitle }}</p>
                        @endif
                        <h2 class="text-2xl font-semibold text-white mb-3 text-pretty">{{ $item->title }}</h2>
                        @if ($item->description)
                            <p class="text-white/65 leading-7 max-w-3xl">{{ $item->description }}</p>
                        @endif

                        @if ($item->image)
                            <div class="mt-6 max-w-3xl overflow-hidden rounded-lg border border-white/10 bg-white/5">
                                @php($itemImageSrcset = \App\Support\OptimizedImage::srcset($item->image))
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                    @if ($itemImageSrcset) srcset="{{ $itemImageSrcset }}" sizes="(min-width: 1024px) 768px, calc(100vw - 3rem)" @endif
                                    class="w-full max-h-[32rem] object-cover" width="1200" height="800" loading="lazy"
                                    decoding="async">
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="rounded-lg border border-white/10 bg-white/[0.03] p-8 text-center text-white/40 italic">
                        No detailed items or assets have been added to this service yet.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
