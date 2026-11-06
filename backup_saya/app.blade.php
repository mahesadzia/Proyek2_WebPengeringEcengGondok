<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Eceng Gondok')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important} body{font-family:'Poppins',ui-sans-serif,system-ui,sans-serif}</style>
</head>
<body class="bg-white text-green-900 antialiased">
<div x-data="{ sidebar: false }" class="min-h-screen md:flex">

    {{-- Overlay mobile --}}
    <div x-cloak x-show="sidebar" @click="sidebar = false" class="fixed inset-0 z-30 bg-black/40 md:hidden"></div>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-gradient-to-b from-green-500 via-green-600 to-green-900 transition-transform md:static md:w-56 md:translate-x-0 lg:w-64"
           :class="{ 'translate-x-0': sidebar }">
        <div class="flex h-20 items-center justify-center border-b-4 border-white/70 px-4">
            <span class="text-xl font-bold italic tracking-tight text-white drop-shadow">ECENG GONDOK</span>
        </div>

        @php
            $nav = [
                [
                    'label'  => 'Beranda',
                    'url'    => Route::has('dashboard') ? route('dashboard') : '#',
                    'active' => request()->routeIs('dashboard'),
                    'icon'   => 'home',
                ],
                [
                    'label'  => 'Batch',
                    'url'    => route('batch.index'),
                    'active' => request()->routeIs('batch.*'),
                    'icon'   => 'cube',
                ],
                [
                    'label'  => 'Pengaturan',
                    'url'    => Route::has('settings.index') ? route('settings.index') : '#',
                    'active' => request()->routeIs('settings.*'),
                    'icon'   => 'cog',
                ],
            ];
        @endphp

        <nav class="mt-5 space-y-1 px-3 text-sm">
            @foreach ($nav as $item)
                <a href="{{ $item['url'] }}"
                   @if($item['active']) aria-current="page" @endif
                   class="flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-white transition focus:outline-none focus-visible:ring-2 focus-visible:ring-white
                          {{ $item['active'] ? 'bg-white/40' : 'hover:bg-white/20' }}">
                    @switch($item['icon'])
                        @case('home')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.126 1.126 0 0 1 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                            @break
                        @case('cube')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                            @break
                        @case('cog')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            @break
                    @endswitch
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </aside>

    {{-- ===== KONTEN UTAMA ===== --}}
    <div class="flex min-w-0 flex-1 flex-col">
        {{-- Topbar --}}
        <header class="flex h-20 items-center justify-between border-b-4 border-gray-300 px-4 sm:px-8">
            <div class="flex items-center gap-3">
                <button type="button" @click="sidebar = true" class="rounded-md p-1 text-green-800 md:hidden" aria-label="Buka menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>
                <h1 class="text-xl font-semibold text-green-800 sm:text-2xl">@yield('page-title')</h1>
            </div>

            <a href="#" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-green-500 to-green-700 px-5 py-2 text-sm font-medium text-white shadow transition hover:brightness-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-700 focus-visible:ring-offset-2">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                Akun
            </a>
        </header>

        <main class="flex-1 p-4 sm:p-8">
            {{-- Flash message --}}
            @foreach (['success' => 'green', 'error' => 'red'] as $key => $color)
                @if (session($key))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" role="alert"
                         class="mb-6 flex items-start justify-between gap-3 rounded-lg border px-4 py-3 text-sm
                                {{ $color === 'green' ? 'border-green-300 bg-green-50 text-green-800' : 'border-red-300 bg-red-50 text-red-800' }}">
                        <span>{{ session($key) }}</span>
                        <button type="button" @click="show = false" aria-label="Tutup">&times;</button>
                    </div>
                @endif
            @endforeach

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>