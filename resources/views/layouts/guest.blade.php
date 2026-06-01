<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Prestige In Media - Creative Digital Agency' }}</title>

    @stack('head')

    {{-- Vite --}}
    @vite('resources/css/guest.css')

</head>

<body class="font-sans bg-brand-dark text-white antialiased">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')

</body>

</html>
