<nav class="fixed left-0 top-0 z-50 w-full border-b border-white/10 bg-brand-darker/95 lg:bg-brand-darker/85 lg:backdrop-blur-sm" aria-label="Primary navigation">
    <input type="checkbox" id="mobile-menu-toggle" class="sr-only" aria-label="Toggle navigation">

    <div class="nav-shell mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between lg:h-20">
            <a href="{{ route('home') }}#home" class="group flex min-h-11 items-center gap-2 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent focus-visible:ring-offset-2 focus-visible:ring-offset-brand-darker">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full border border-white/10 bg-white/5">
                    <img
                        src="{{ asset('logo.webp') }}"
                        alt="Prestige In Media logo"
                        class="h-full w-full object-cover"
                        width="40"
                        height="40"
                        loading="eager"
                        decoding="async"
                    >
                </span>
                <span class="hidden text-sm font-bold uppercase tracking-wide text-white sm:block">
                    Prestige <span class="text-brand-accent">In Media</span>
                </span>
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('home') }}#home" class="nav-link">Home</a>
                <a href="{{ route('home') }}#about" class="nav-link">About</a>
                <a href="{{ route('home') }}#services" class="nav-link">Services</a>
                <a href="{{ route('home') }}#pricing" class="nav-link">Pricing</a>
                <a href="{{ route('home') }}#contact" class="nav-link">Contact</a>
            </div>

            <div class="hidden items-center gap-4 lg:flex">
                <a href="{{ route('home') }}#contact" class="btn btn-primary min-h-10 px-5 py-2.5">
                    Konsultasi Sekarang
                </a>
            </div>

            <label
                for="mobile-menu-toggle"
                class="mobile-menu-button flex h-11 w-11 cursor-pointer flex-col items-center justify-center gap-1.5 rounded-md border border-white/10 bg-white/5 lg:hidden"
                role="button"
                aria-controls="mobile-menu-panel"
            >
                <span class="block h-0.5 w-5 bg-white" aria-hidden="true"></span>
                <span class="block h-0.5 w-5 bg-white" aria-hidden="true"></span>
                <span class="block h-0.5 w-5 bg-white" aria-hidden="true"></span>
                <span class="sr-only">Open menu</span>
            </label>
        </div>
    </div>

    <div id="mobile-menu-panel" class="mobile-menu-panel max-h-[calc(100svh-4rem)] overflow-y-auto border-t border-white/10 bg-brand-darker lg:hidden">
        <div class="flex flex-col gap-1 px-5 py-5 sm:px-6">
            <a href="{{ route('home') }}#home" class="mobile-nav-link mobile-nav-link-active">Home</a>
            <a href="{{ route('home') }}#about" class="mobile-nav-link">About</a>
            <a href="{{ route('home') }}#services" class="mobile-nav-link">Services</a>
            <a href="{{ route('home') }}#pricing" class="mobile-nav-link">Pricing</a>
            <a href="{{ route('home') }}#contact" class="mobile-nav-link">Contact</a>
            <div class="mt-4 border-t border-white/10 pt-4">
                <a href="{{ route('home') }}#contact" class="btn btn-primary">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</nav>
