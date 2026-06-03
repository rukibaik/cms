<section
    class="content-visibility-auto relative overflow-hidden bg-brand-darker py-20 lg:py-28"
    id="services"
>
    <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 border-b border-white/10 pb-12 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <div class="flex items-center gap-3">
                    <span class="h-px w-12 bg-brand-accent"></span>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-brand-accent">Services</p>
                </div>
                <h2 class="mt-4 font-serif text-3xl font-bold tracking-tight text-white text-balance sm:text-4xl lg:text-5xl">
                    {{ $serviceSection?->title ?: 'Services' }}
                </h2>
                @if ($serviceSection?->subtitle)
                    <p class="mt-4 max-w-xl text-base leading-7 text-white/65 text-pretty">{{ $serviceSection->subtitle }}</p>
                @endif
            </div>

            @if ($serviceSection?->button_text)
                <a
                    class="btn btn-outline"
                    href="{{ $serviceSection->button_link ?: route('home') . '#contact' }}"
                >
                    {{ $serviceSection->button_text }}
                </a>
            @endif
        </div>

        @if ($services->isEmpty())
            <div
                class="mt-10 rounded-lg border border-dashed border-white/15 bg-white/5 px-6 py-12 text-center text-white/45">
                Services will appear here once they are published from the CMS.
            </div>
        @else
            <div class="mt-10 grid auto-rows-fr gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($services as $service)
                    <a
                        class="group flex h-full flex-col overflow-hidden rounded-lg border border-white/10 bg-white/5 transition duration-150 hover:border-brand-accent/40 hover:bg-brand-accent/[0.08] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent focus-visible:ring-offset-2 focus-visible:ring-offset-brand-darker lg:hover:-translate-y-0.5"
                        href="{{ route('services.show', $service->slug) }}"
                    >
                        <div class="flex min-h-56 flex-1 flex-col bg-white/5 p-6">
                            <div class="flex items-start justify-between gap-3">
                                <span
                                    class="inline-flex rounded-md bg-brand-accent/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-brand-accent"
                                >
                                    Service
                                </span>
                                <span class="shrink-0 text-right text-xs font-semibold uppercase tracking-[0.2em] text-white/50">
                                    {{ $service->items_count ?? $service->items->count() }}
                                    item{{ ($service->items_count ?? $service->items->count()) === 1 ? '' : 's' }}
                                </span>
                            </div>
                            <h3 class="mt-6 text-2xl font-semibold text-white text-pretty">{{ $service->title }}</h3>
                            @if ($service->subtitle)
                                <p class="mt-4 text-sm leading-6 text-white/60 text-pretty">{{ $service->subtitle }}</p>
                            @endif
                        </div>
                        <div class="btn-card mt-auto">
                            View details
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
