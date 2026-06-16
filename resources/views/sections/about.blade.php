<section
    class="content-visibility-auto relative overflow-hidden bg-[linear-gradient(180deg,#050505_0%,#061B5E_52%,#050505_100%)] py-20 lg:py-28"
    id="about"
>
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-accent/30 to-transparent pointer-events-none"></div>

    <div class="relative mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="max-w-2xl">
                @if ($about?->subtitle)
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-white sm:tracking-[0.26em]">
                        {{ $about->subtitle }}
                    </p>
                @endif

                @if ($about?->title)
                    <h2 class="mt-5 text-3xl font-bold leading-tight tracking-tight text-white text-balance sm:text-4xl lg:text-5xl">
                        {!! str($about->title)->replace('Naik Level', '<span class="font-bold italic text-brand-accent ">Naik Level</span>')->replace('Kreatif', '<span class="text-brand-accent">Kreatif</span>') !!}
                    </h2>
                @endif

                @if ($about?->description)
                    <p class="mt-8 max-w-xl text-base leading-relaxed text-white/70 text-pretty lg:text-lg">
                        {{ $about->description }}
                    </p>
                @else
                    <p class="mt-8 text-white/40 italic">Description has not been added yet.</p>
                @endif
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @if (isset($services) && $services->isNotEmpty())
                    @foreach ($services->take(4) as $service)
                        @php($isBlueCard = $loop->even)
                        <a
                            @class([
                                'block h-full rounded-lg border p-6 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent focus-visible:ring-offset-2 focus-visible:ring-offset-brand-darker',
                                'border-brand-accent bg-brand-accent text-white hover:border-white/25 hover:bg-brand-accent' => $isBlueCard,
                                'border-white bg-white text-brand-dark hover:border-brand-accent hover:bg-white' => ! $isBlueCard,
                            ])
                            href="{{ route('services.show', $service->slug) }}"
                        >
                            <div class="flex items-center justify-between gap-3">
                                <div @class([
                                    'flex h-12 w-12 shrink-0 items-center justify-center rounded-md',
                                    'bg-white/15 text-white' => $isBlueCard,
                                    'bg-brand-accent text-white' => ! $isBlueCard,
                                ])>
                                    <span class="text-sm font-semibold">{{ $loop->iteration }}</span>
                                </div>
                                <span @class([
                                    'rounded-md border px-3 py-1 text-[11px] uppercase tracking-[0.16em]',
                                    'border-white/20 bg-white/10 text-white/80' => $isBlueCard,
                                    'border-brand-accent/20 bg-brand-accent/10 text-brand-accent' => ! $isBlueCard,
                                ])>
                                    Service
                                </span>
                            </div>
                            <h3 @class([
                                'mt-6 text-xl font-semibold text-pretty',
                                'text-white' => $isBlueCard,
                                'text-brand-dark' => ! $isBlueCard,
                            ])>{{ $service->title }}</h3>
                            @if ($service->subtitle)
                                <p @class([
                                    'mt-3 text-sm leading-6',
                                    'text-white/75' => $isBlueCard,
                                    'text-brand-dark/65' => ! $isBlueCard,
                                ])>{{ $service->subtitle }}</p>
                            @endif
                            <div @class([
                                'mt-6 inline-flex min-h-10 items-center gap-2 text-sm font-semibold',
                                'text-white' => $isBlueCard,
                                'text-brand-accent' => ! $isBlueCard,
                            ])>
                                <span>Learn more</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6" />
                                </svg>
                            </div>
                        </a>
                    @endforeach
                @else
                    @foreach (['Photo Product', 'Video Commercial', 'Social Media Management', 'Branding'] as $label)
                        @php($isBlueCard = $loop->even)
                        <article @class([
                            'h-full rounded-lg border p-6',
                            'border-brand-accent bg-brand-accent text-white' => $isBlueCard,
                            'border-white bg-white text-brand-dark' => ! $isBlueCard,
                        ])>
                            <div class="flex items-center justify-between gap-3">
                                <div @class([
                                    'flex h-12 w-12 shrink-0 items-center justify-center rounded-md',
                                    'bg-white/15 text-white' => $isBlueCard,
                                    'bg-brand-accent text-white' => ! $isBlueCard,
                                ])>
                                    <span class="text-sm font-semibold">&middot;</span>
                                </div>
                                <span @class([
                                    'rounded-md border px-3 py-1 text-[11px] uppercase tracking-[0.16em]',
                                    'border-white/20 bg-white/10 text-white/80' => $isBlueCard,
                                    'border-brand-accent/20 bg-brand-accent/10 text-brand-accent' => ! $isBlueCard,
                                ])>
                                    Service
                                </span>
                            </div>
                            <h3 @class([
                                'mt-6 text-xl font-semibold',
                                'text-white' => $isBlueCard,
                                'text-brand-dark' => ! $isBlueCard,
                            ])>{{ $label }}</h3>
                            <p @class([
                                'mt-3 text-sm leading-6',
                                'text-white/75' => $isBlueCard,
                                'text-brand-dark/65' => ! $isBlueCard,
                            ])>
                                Kami bantu brand Anda tampil lebih kuat lewat konten visual dan strategi kreatif.
                            </p>
                        </article>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
