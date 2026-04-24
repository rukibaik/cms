@extends('layouts.guest')

@section('content')
    <section class="bg-brand-darker min-h-screen pt-28 pb-20 lg:pt-36 lg:pb-24">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <a href="{{ route('home') }}#services"
                class="inline-flex items-center gap-2 text-sm text-brand-accent hover:text-brand-accent-light transition mb-8">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Services
            </a>

            <div class="mt-6 border-b border-white/10 pb-8">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-accent mb-2">Service Detail</p>
                <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white">
                    {{ $service->title }}</h1>
                @if ($service->subtitle)
                    <p class="mt-3 text-lg text-white/65">{{ $service->subtitle }}</p>
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
                        <h2 class="text-2xl font-semibold text-white mb-3">{{ $item->title }}</h2>
                        @if ($item->description)
                            <p class="text-white/65 leading-7 max-w-3xl">{{ $item->description }}</p>
                        @endif

                        @if ($item->image)
                            <div class="mt-6 overflow-hidden rounded-sm border border-white/10 max-w-3xl">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                    class="w-full max-h-[32rem] object-cover" loading="lazy">
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="rounded-sm border border-white/10 bg-white/[0.03] p-8 text-center text-white/40 italic">
                        No detailed items or assets have been added to this service yet.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
