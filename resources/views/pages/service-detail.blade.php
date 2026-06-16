@extends('layouts.guest')

@section('content')
    <section class="min-h-[100svh] bg-radial from-blue-900 via-slate-950 to-black bg-right-bottom  pb-20 pt-28 lg:pb-24 lg:pt-36">
        <div class="mx-auto max-w-6xl px-5 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}#services"
                class="mb-8 inline-flex min-h-11 items-center gap-2 rounded-md text-sm font-semibold text-white transition-colors duration-150 hover:text-brand-accent-light focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Services
            </a>

            <div class="mt-6 border-b border-brand-accent pb-8">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs uppercase tracking-[0.2em] text-white">Service Detail</p>
                    <a href="https://www.instagram.com/prestigeworkpage/" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
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

            <div class="mt-12 grid auto-rows-fr gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($service->items as $item)
                    <article class="group flex h-full scroll-mt-32 flex-col overflow-hidden rounded-lg border border-white/10 bg-white/[0.04] transition-colors duration-150 hover:border-brand-accent/35 hover:bg-brand-accent/[0.07]">
                        @if ($item->image)
                            <div class="aspect-[4/3] overflow-hidden border-b border-white/10 bg-white/5">
                                @php($itemImageSrcset = \App\Support\OptimizedImage::srcset($item->image))
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                    @if ($itemImageSrcset) srcset="{{ $itemImageSrcset }}" sizes="(min-width: 1280px) 390px, (min-width: 640px) 50vw, calc(100vw - 2.5rem)" @endif
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]" width="1200" height="800" loading="lazy"
                                    decoding="async">
                            </div>
                        @else
                            <div class="flex aspect-[4/3] items-center justify-center border-b border-white/10 bg-white/[0.03] text-xs font-semibold uppercase tracking-[0.2em] text-white/30">
                                Service
                            </div>
                        @endif

                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            @if ($item->subtitle)
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-accent">{{ $item->subtitle }}</p>
                            @endif
                            <h2 class="{{ $item->subtitle ? 'mt-3' : '' }} text-xl font-semibold leading-snug text-white text-pretty">
                                {{ $item->title }}</h2>
                            @if ($item->description)
                                <p class="mt-4 text-sm leading-6 text-white/65 text-pretty">{{ $item->description }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="rounded-lg border border-white/10 bg-white/[0.03] p-8 text-center text-white/40 italic sm:col-span-2 xl:col-span-3">
                        No detailed items or assets have been added to this service yet.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
