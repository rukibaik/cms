    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-zinc-900 sm:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-full bg-zinc-950">
                        <img
                            src="{{ asset('logo.webp') }}"
                            alt="Prestige In Media logo"
                            class="h-full w-full object-cover"
                            width="56"
                            height="56"
                            loading="eager"
                            decoding="async"
                        >
                    </span>
                    <div>
                        <h1 class="text-xl font-semibold text-zinc-950 dark:text-white">Prestige In Media</h1>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">CMS dashboard overview</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid auto-rows-fr gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Services</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-950 dark:text-white">{{ $serviceCount }}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pricing Plans</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-950 dark:text-white">{{ $pricingCount }}</p>
            </div>
        </div>
    </div>
