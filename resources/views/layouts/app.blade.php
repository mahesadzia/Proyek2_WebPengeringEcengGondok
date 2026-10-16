<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Beranda') · {{ config('app.name', 'Eceng Gondok') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-eg-dark antialiased">

    {{-- Overlay untuk sidebar di layar kecil --}}
    <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-black/40 lg:hidden"></div>

    @include('partials.sidebar')

    <div class="lg:pl-72">
        @include('partials.topbar', ['pageTitle' => View::yieldContent('page-title', 'Beranda')])

        <main class="px-5 pb-12 pt-6 sm:px-8">
            @include('partials.flash-message')

            @yield('content')
        </main>
    </div>

    <script>
        (() => {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggle  = document.getElementById('sidebar-toggle');
            const set = (open) => {
                sidebar.classList.toggle('-translate-x-full', !open);
                overlay.classList.toggle('hidden', !open);
                toggle.setAttribute('aria-expanded', open);
            };
            toggle.addEventListener('click', () =>