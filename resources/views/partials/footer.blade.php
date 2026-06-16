<footer class="relative border-t border-[#1a1a1a] bg-gradient-to-b from-black via-[#111827] to-blue-600/50">
    <div class="mx-auto max-w-7xl px-5 py-14 sm:px-6 lg:px-8 lg:py-20">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">
            <div>
                <h2 class="mb-8 text-9xl font-bold leading-tight tracking-tight text-white text-balance sm:text-4xl lg:text-7xl">
                    Siap Mulai
                    <br>
                    <span class="font-bold italic text-brand-accent">Proyek?</span>
                </h2>
                <a href="{{ route('home') }}#contact" class="btn btn-light">
                    Mari Diskusi
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            <div class="flex flex-col items-start gap-4 lg:items-end">
                <a href="https://www.instagram.com/prestigeworkpage/" target="_blank" rel="noopener noreferrer" class="social-link">
                    <span class="text-sm font-medium tracking-wide">Instagram</span>
                    <span class="social-icon">
                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                    </span>
                </a>

                <a href="mailto:hello@prestigeinmedia.com" class="social-link">
                    <span class="text-sm font-medium tracking-wide">Email</span>
                    <span class="social-icon">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0-9.75 6-9.75-6" />
                        </svg>
                    </span>
                </a>

                <a href="{{ route('home') }}#contact" class="social-link">
                    <span class="text-sm font-medium tracking-wide">Contact</span>
                    <span class="social-icon">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="border-t border-white/5">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-5 py-6 text-center sm:flex-row sm:px-6 sm:text-left lg:px-8">
            <p class="text-xs text-white/35">
                Copyright 2026 PT. INTERNASIONAL MEDIA CORP
            </p>
            <a href="{{ route('home') }}#home" class="rounded-md text-xs font-medium text-white/35 transition-colors duration-150 hover:text-white/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent focus-visible:ring-offset-2 focus-visible:ring-offset-brand-darker">
                Back to top
            </a>
        </div>
    </div>
</footer>
