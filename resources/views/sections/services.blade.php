<section class="py-20">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">
        <div class="max-w-2xl">
            <p class="text-sm uppercase tracking-[0.2em] text-brand-accent">Services</p>
            <h2 class="mt-3 text-3xl font-semibold text-white">
                {{ $serviceSection?->title ?: 'Services' }}
            </h2>
            @if ($serviceSection?->subtitle)
                <p class="mt-3 text-white/65">{{ $serviceSection->subtitle }}</p>
            @endif
        </div>

        <div class="grid gap-4 mt-10 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($services as $service)
            <a href="{{ route('services.show', $service->slug) }}"
                class="group rounded-2xl border border-white/10 bg-white/[0.03] p-5 transition hover:-translate-y-1 hover:border-white/20">
                @if ($service->items->first()?->image)
                    <img src="{{ asset('storage/' . $service->items->first()->image) }}" alt="{{ $service->title }}"
                        class="h-48 w-full rounded-xl object-cover">
                @endif

                <h3 class="mt-4 text-xl font-semibold text-white">{{ $service->title }}</h3>
                @if ($service->subtitle)
                    <p class="mt-2 text-white/60">{{ $service->subtitle }}</p>
                @endif
                <p class="mt-4 text-sm font-medium text-brand-accent group-hover:text-brand-accent-light">
                    View details
                </p>
            </a>
        @endforeach
        </div>

        @if ($serviceSection?->button_text)
            <div class="mt-10">
                <a href="{{ $serviceSection->button_link ?: '#services' }}"
                    class="inline-flex items-center rounded-full border border-brand-accent/30 px-5 py-3 text-sm font-medium text-brand-accent transition hover:bg-brand-accent/10">
                    {{ $serviceSection->button_text }}
                </a>
            </div>
        @endif
    </div>

</section>
