<nav class="fixed top-0 left-0 w-full z-50 border-b border-white/10 bg-brand-darker/80 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">

            <!-- Logo -->
            <a href="#" class="flex items-center gap-2 group">
                <div
                    class="w-8 h-8 bg-brand-accent rounded-sm flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                    <span class="text-brand-dark font-black text-sm">P</span>
                </div>
                <span class="text-white font-bold text-sm tracking-wider uppercase hidden sm:block">
                    Prestige <span class="text-brand-accent">In Media</span>
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1">
                <a href="#home"
                    class="px-4 py-2 text-sm font-medium text-brand-accent rounded-sm transition-colors duration-150">Home</a>
                <a href="#about"
                    class="px-4 py-2 text-sm font-medium text-white/70 hover:text-white rounded-sm transition-colors duration-150">About</a>
                <a href="#"
                    class="px-4 py-2 text-sm font-medium text-white/70 hover:text-white rounded-sm transition-colors duration-150">Services</a>
                <a href="#"
                    class="px-4 py-2 text-sm font-medium text-white/70 hover:text-white rounded-sm transition-colors duration-150">Portfolio</a>
                <a href="#"
                    class="px-4 py-2 text-sm font-medium text-white/70 hover:text-white rounded-sm transition-colors duration-150">Contact</a>
            </div>

            <!-- CTA Button Desktop -->
            <div class="hidden lg:flex items-center gap-4">
                <a href="#"
                    class="px-6 py-2.5 bg-brand-accent text-brand-dark text-sm font-semibold rounded-sm hover:bg-brand-accent-light transition-colors duration-150">
                    Get Started
                </a>
            </div>

            <!-- Mobile Menu Button (CSS-only toggle) -->
            <input type="checkbox" id="mobile-menu-toggle" class="hidden peer">
            <label for="mobile-menu-toggle"
                class="lg:hidden flex flex-col items-center justify-center w-10 h-10 cursor-pointer gap-1.5">
                <span
                    class="block w-5 h-0.5 bg-white transition-all duration-300 peer-checked:rotate-45 peer-checked:translate-y-2"></span>
                <span class="block w-5 h-0.5 bg-white transition-all duration-300 peer-checked:opacity-0"></span>
                <span
                    class="block w-5 h-0.5 bg-white transition-all duration-300 peer-checked:-rotate-45 peer-checked:-translate-y-2"></span>
            </label>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="lg:hidden hidden peer-checked:block border-t border-white/10 bg-brand-darker/95 backdrop-blur-md">
        <div class="px-6 py-6 flex flex-col gap-1">
            <a href="#home" class="px-4 py-3 text-sm font-medium text-brand-accent rounded-sm bg-white/5">Home</a>
            <a href="#about"
                class="px-4 py-3 text-sm font-medium text-white/70 hover:text-white hover:bg-white/5 rounded-sm transition-colors">About</a>
            <a href="#"
                class="px-4 py-3 text-sm font-medium text-white/70 hover:text-white hover:bg-white/5 rounded-sm transition-colors">Services</a>
            <a href="#"
                class="px-4 py-3 text-sm font-medium text-white/70 hover:text-white hover:bg-white/5 rounded-sm transition-colors">Portfolio</a>
            <a href="#"
                class="px-4 py-3 text-sm font-medium text-white/70 hover:text-white hover:bg-white/5 rounded-sm transition-colors">Contact</a>
            <div class="mt-4 pt-4 border-t border-white/10">
                <a href="#"
                    class="block text-center px-6 py-3 bg-brand-accent text-brand-dark text-sm font-semibold rounded-sm hover:bg-brand-accent-light transition-colors">Get
                    Started</a>
            </div>
        </div>
    </div>
</nav>
