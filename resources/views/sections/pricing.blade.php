<section id="pricing" class="content-visibility-auto relative overflow-hidden bg-[linear-gradient(180deg,#050505_0%,#061B5E_52%,#050505_100%)] py-20 lg:py-28">
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-accent/50 to-transparent pointer-events-none"></div>

    <div class="relative mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 lg:mb-20">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="w-8 h-px bg-white/45"></div>
                <span class="rounded-md bg-white px-3 py-1 text-xs font-semibold tracking-[0.2em] uppercase text-brand-accent">Pricing</span>
                <div class="w-8 h-px bg-white/45"></div>
            </div>
            <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight tracking-tight mb-4 text-balance">
                Harga Yang Sederhana
                <br class="hidden sm:block">
                Dan <span class="text-white">Terjangkau</span>
            </h2>
            <p class="leading-relaxed text-white/72 text-pretty">
                Pilih paket yang sesuai dengan kebutuhan dan skala bisnis Anda.
            </p>
        </div>

        @if ($pricings->isEmpty())
            <div class="rounded-lg border border-white bg-white p-8 text-center text-brand-dark/65 shadow-xl shadow-black/15">
                No pricing plans have been added yet.
            </div>
        @else
            <div class="grid items-stretch gap-6 md:grid-cols-2 lg:gap-8 xl:grid-cols-3">
                @foreach ($pricings as $pricing)
                    @php
                        $isFeatured = $pricing->is_featured;
                        $isBlueCard = $isFeatured || $loop->iteration % 3 === 2;
                        $formattedPrice = number_format((float) $pricing->price, 0, ',', '.');
                    @endphp
                    <div @class([
                        'group relative flex h-full flex-col rounded-lg border p-6 transition duration-150 sm:p-8 lg:p-10',
                        'border-brand-accent bg-brand-accent text-white shadow-xl shadow-brand-accent/25 hover:-translate-y-0.5' => $isBlueCard,
                        'border-white bg-white text-brand-dark shadow-xl shadow-black/15 hover:-translate-y-0.5 hover:border-brand-accent' => ! $isBlueCard,
                    ])>
                        @if ($isFeatured)
                            <div
                                class="absolute -top-3.5 left-1/2 -translate-x-1/2 rounded-md bg-white px-5 py-1 text-[10px] font-bold uppercase tracking-[0.15em] text-brand-accent shadow-lg shadow-black/10">
                                Featured
                            </div>
                        @endif
                        <div class="mb-8">
                            <span @class([
                                'text-xs font-semibold tracking-[0.15em] uppercase',
                                'text-white/80' => $isBlueCard,
                                'text-brand-accent' => ! $isBlueCard,
                            ])>
                                {{ $pricing->name }}
                            </span>
                            <div class="mt-4 flex flex-wrap items-baseline gap-x-1 gap-y-2">
                                <span @class([
                                    'text-sm font-medium',
                                    'text-white/70' => $isBlueCard,
                                    'text-brand-dark/55' => ! $isBlueCard,
                                ])>Rp</span>
                                <span @class([
                                    'break-all text-3xl font-bold sm:text-4xl lg:text-5xl',
                                    'text-white' => $isBlueCard,
                                    'text-brand-dark' => ! $isBlueCard,
                                ])>{{ $formattedPrice }}</span>
                                <span @class([
                                    'text-lg',
                                    'text-white/70' => $isBlueCard,
                                    'text-brand-dark/55' => ! $isBlueCard,
                                ])>/mo</span>
                            </div>
                            @if ($pricing->description)
                                <p @class([
                                    'mt-4 text-sm leading-6',
                                    'text-white/76' => $isBlueCard,
                                    'text-brand-dark/65' => ! $isBlueCard,
                                ])>{{ $pricing->description }}</p>
                            @endif
                        </div>
                        <div @class([
                            'mb-8 h-px w-full',
                            'bg-white/22' => $isBlueCard,
                            'bg-brand-accent/20' => ! $isBlueCard,
                        ])></div>
                        <ul class="mb-10 flex-1 space-y-4">
                            @forelse ($pricing->benefits as $benefit)
                                <li class="flex items-start gap-3">
                                    <svg @class([
                                        'mt-0.5 h-4 w-4 flex-shrink-0',
                                        'text-white' => $isBlueCard,
                                        'text-brand-accent' => ! $isBlueCard,
                                    ])
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span @class([
                                        'text-sm',
                                        'text-white/82' => $isBlueCard,
                                        'text-brand-dark/70' => ! $isBlueCard,
                                    ])>{{ $benefit->benefit }}</span>
                                </li>
                            @empty
                                <li @class([
                                    'text-sm',
                                    'text-white/65' => $isBlueCard,
                                    'text-brand-dark/45' => ! $isBlueCard,
                                ])>No benefits added yet.</li>
                            @endforelse
                        </ul>
                        <a href="{{ $pricing->button_link ?: route('home') . '#contact' }}"
                            @class([
                                'btn w-full border',
                                'border-white bg-white text-brand-accent hover:bg-white hover:text-brand-accent' => $isBlueCard,
                                'border-brand-accent bg-brand-accent text-white hover:bg-brand-accent hover:text-white' => ! $isBlueCard,
                            ])
                            aria-label="View {{ $pricing->name }} plan">
                            {{ $pricing->button_text ?: 'Get Started' }}
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
