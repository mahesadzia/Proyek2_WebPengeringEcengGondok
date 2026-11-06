<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Beranda') · Eceng Gondok</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-base leading-relaxed text-eg-dark antialiased">

    <a href="#konten"
       class="sr-only focus:not-sr-only focus:fixed focus:left-3 focus:top-3 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-medium focus:text-eg-dark focus:shadow-lg">
        Lewati ke konten
    </a>

    {{-- Overlay untuk sidebar di layar kecil --}}
    <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-black/50 lg:hidden"></div>

    @include('partials.sidebar')

    <div class="lg:pl-72">
        @include('partials.topbar', ['pageTitle' => View::yieldContent('page-title', 'Beranda')])

        <main id="konten" class="px-5 pb-12 pt-6 sm:px-8">
            @include('partials.flash-message')

            @yield('content')
        </main>
    </div>

    <script>
        (() => {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggle  = document.getElementById('sidebar-toggle');
            if (!sidebar || !overlay || !toggle) return;

            const set = (open) => {
                sidebar.classList.toggle('-translate-x-full', !open);
                overlay.classList.toggle('hidden', !open);
                toggle.setAttribute('aria-expanded', String(open));
            };

            toggle.addEventListener('click', () => set(toggle.getAttribute('aria-expanded') !== 'true'));
            overlay.addEventListener('click', () => set(false));
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') set(false); });
        })();
    </script>
</body>
</html>
