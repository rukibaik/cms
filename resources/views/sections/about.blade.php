<section
    class="content-visibility-auto relative overflow-hidden bg-brand-darker py-24 lg:py-32"
    id="about"
>
    <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-brand-accent/10 to-transparent pointer-events-none"></div>
    <div class="absolute right-0 top-1/3 hidden h-[420px] w-[420px] rounded-full bg-brand-accent/[0.06] blur-3xl pointer-events-none lg:block"></div>

    <div class="relative mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="max-w-2xl">
                @if ($about?->subtitle)
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-brand-accent sm:tracking-[0.3em]">
                        {{ $about->subtitle }}
                    </p>
                @endif

                @if ($about?->title)
                    <h2 class="mt-5 text-3xl font-bold leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl">
                        {!! str($about->title)->replace('Naik Level', '<span class="text-brand-accent">Naik Level</span>')->replace('Kreatif', '<span class="text-brand-accent">Kreatif</span>') !!}
                    </h2>
                @endif

                @if ($about?->description)
                    <p class="mt-8 max-w-xl text-base leading-relaxed text-white/70 lg:text-lg">
                        {{ $about->description }}
                    </p>
                @else
                    <p class="mt-8 text-white/40 italic">Description has not been added yet.</p>
                @endif
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @if (isset($services) && $services->isNotEmpty())
                    @foreach ($services->take(4) as $service)
                        <a
                            class="block rounded-[1.5rem] border border-white/10 bg-white/5 p-6 transition-colors duration-150 hover:border-brand-accent/30 hover:bg-brand-accent/[0.08] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent focus-visible:ring-offset-2 focus-visible:ring-offset-brand-darker sm:rounded-[1.75rem]"
                            href="{{ route('services.show', $service->slug) }}"
                        >
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-accent/15 text-brand-accent">
                                    <span class="text-sm font-semibold">{{ $loop->iteration }}</span>
                                </div>
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] uppercase tracking-[0.18em] text-white/70">
                                    Service
                                </span>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold text-white">{{ $service->title }}</h3>
                            @if ($service->subtitle)
                                <p class="mt-3 text-sm leading-6 text-white/60">{{ $service->subtitle }}</p>
                            @endif
                            <div class="mt-6 inline-flex min-h-10 items-center gap-2 text-sm font-semibold text-brand-accent">
                                <span>Learn more</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6" />
                                </svg>
                            </div>
                        </a>
                    @endforeach
                @else
                    @foreach (['Photo Product', 'Video Commercial', 'Social Media Management', 'Branding'] as $label)
                        <article class="rounded-[1.5rem] border border-white/10 bg-white/5 p-6 sm:rounded-[1.75rem]">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-accent/15 text-brand-accent">
                                    <span class="text-sm font-semibold">&middot;</span>
                                </div>
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] uppercase tracking-[0.18em] text-white/70">
                                    Service
                                </span>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold text-white">{{ $label }}</h3>
                            <p class="mt-3 text-sm leading-6 text-white/60">
                                Kami bantu brand Anda tampil lebih kuat lewat konten visual dan strategi kreatif.
                            </p>
                        </article>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
