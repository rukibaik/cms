@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Prestige In Media" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-9 items-center justify-center overflow-hidden rounded-full bg-zinc-950">
            <img
                src="{{ asset('logo.webp') }}"
                alt=""
                class="h-full w-full object-cover"
                width="36"
                height="36"
                loading="eager"
                decoding="async"
            >
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Prestige In Media" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-9 items-center justify-center overflow-hidden rounded-full bg-zinc-950">
            <img
                src="{{ asset('logo.webp') }}"
                alt=""
                class="h-full w-full object-cover"
                width="36"
                height="36"
                loading="eager"
                decoding="async"
            >
        </x-slot>
    </flux:brand>
@endif
