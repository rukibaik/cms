<!-- FOR LANDING PAGE -->
@extends('layouts.guest')

<!-- INI NGAMBIL BACKGROUND IMAGE DARI DATABASE -->
@php
    $heroImage = $hero?->background_image;
    $heroImageSrcset = \App\Support\OptimizedImage::srcset($heroImage);
@endphp

<!-- KALO BACKGROUND IMAGE ITU GA ADA, BLANK HITAM -->
@if ($heroImage)
    @push('head')
        <link
            rel="preload"
            as="image"
            href="{{ asset('storage/' . $heroImage) }}"
            @if ($heroImageSrcset) imagesrcset="{{ $heroImageSrcset }}" imagesizes="100vw" @endif
            fetchpriority="high"
        >
    @endpush
@endif

@section('content')
    @include('sections.hero')
    @include('sections.about')
    @include('sections.services')
    @include('sections.benefits')
    @include('sections.pricing')
    @include('sections.CTA')
    @include('sections.contact')
@endsection
