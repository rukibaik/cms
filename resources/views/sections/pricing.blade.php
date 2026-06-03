<section id="pricing" class="content-visibility-auto relative overflow-hidden bg-brand-darker py-20 lg:py-28">
    <div class="relative mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 lg:mb-20">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="w-8 h-px bg-brand-accent"></div>
                <span class="text-xs font-semibold tracking-[0.2em] uppercase text-brand-accent">Pricing</span>
                <div class="w-8 h-px bg-brand-accent"></div>
            </div>
            <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight tracking-tight mb-4 text-balance">
                Harga Yang Sederhana
                <br class="hidden sm:block">
                Dan <span class="text-brand-accent">Terjangkau</span>
            </h2>
            <p class="leading-relaxed text-white/55 text-pretty">
                Pilih paket yang sesuai dengan kebutuhan dan skala bisnis Anda.
            </p>
        </div>

        @if ($pricings->isEmpty())
            <div class="rounded-lg border border-white/10 bg-white/[0.02] p-8 text-center text-white/60">
                No pricing plans have been added yet.
            </div>
        @else
            <div class="grid items-start gap-6 md:grid-cols-2 lg:gap-8 xl:grid-cols-3">
                @foreach ($pricings as $pricing)
                    @php
                        $isFeatured = $pricing->is_featured;
                        $formattedPrice = number_format((float) $pricing->price, 0, ',', '.');
                    @endphp
                    <div
                        class="group relative rounded-lg border p-6 transition-colors duration-150 sm:p-8 lg:p-10 {{ $isFeatured ? 'border-brand-accent/50 bg-brand-accent/[0.08] shadow-lg shadow-brand-accent/10' : 'border-white/10 bg-white/[0.03] hover:border-white/20' }}">
                        @if ($isFeatured)
                            <div
                                class="absolute -top-3.5 left-1/2 -translate-x-1/2 rounded-md bg-brand-accent px-5 py-1 text-[10px] font-bold uppercase tracking-[0.15em] text-white">
                                Featured
                            </div>
                        @endif
                        <div class="mb-8">
                            <span
                                class="text-xs font-semibold tracking-[0.15em] uppercase {{ $isFeatured ? 'text-brand-accent' : 'text-white/40' }}">
                                {{ $pricing->name }}
                            </span>
                            <div class="mt-4 flex flex-wrap items-baseline gap-x-1 gap-y-2">
                                <span class="text-sm text-white/50 font-medium">Rp</span>
                                <span
                                    class="break-all text-3xl font-bold text-white sm:text-4xl lg:text-5xl">{{ $formattedPrice }}</span>
                                <span class="text-lg text-white/50">/mo</span>
                            </div>
                            @if ($pricing->description)
                                <p class="mt-4 text-sm text-white/60 leading-6">{{ $pricing->description }}</p>
                            @endif
                        </div>
                        <div class="w-full h-px {{ $isFeatured ? 'bg-brand-accent/20' : 'bg-white/10' }} mb-8"></div>
                        <ul class="space-y-4 mb-10">
                            @forelse ($pricing->benefits as $benefit)
                                <li class="flex items-start gap-3">
                                    <svg class="w-4 h-4 {{ $isFeatured ? 'text-brand-accent' : 'text-white/40' }} mt-0.5 flex-shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm text-white/70">{{ $benefit->benefit }}</span>
                                </li>
                            @empty
                                <li class="text-sm text-white/40">No benefits added yet.</li>
                            @endforelse
                        </ul>
                        <a href="{{ $pricing->button_link ?: route('home') . '#contact' }}"
                            class="btn w-full {{ $isFeatured ? 'btn-primary' : 'btn-secondary' }}"
                            aria-label="View {{ $pricing->name }} plan">
                            {{ $pricing->button_text ?: 'Get Started' }}
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
