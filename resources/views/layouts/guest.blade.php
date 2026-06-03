<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#050505">

    <title>{{ $title ?? 'Prestige In Media - Creative Digital Agency' }}</title>
    <meta
        name="description"
        content="{{ $metaDescription ?? 'Prestige In Media membantu brand membangun konten visual, strategi kreatif, dan media digital yang modern.' }}"
    >

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @stack('head')

    @vite('resources/css/guest.css')

</head>

<body class="font-sans bg-brand-dark text-white antialiased">
    <a href="#main-content" class="skip-link">Skip to content</a>

    @include('partials.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')

</body>

</html>
