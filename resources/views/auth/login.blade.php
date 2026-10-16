<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · {{ config('app.name', 'Eceng Gondok') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-b from-eg-leaf to-eg-deep px-4 font-sans text-eg-dark antialiased">

    <main class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl sm:p-10">
        <p class="-skew-x-6 text-center text-3xl font-bold italic tracking-tight text-eg-leaf">ECENG GONDOK</p>
        <h1 class="mt-6 text-center text-2xl font-bold tracking-tight">Masuk ke akun Anda</h1>

        @if (session('success'))
            <p role="status" class="mt-5 rounded-lg border-l-4 border-eg-moss bg-eg-lime/50 px-4 py-3 text-sm">
                {{ session('success') }}
            </p>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5" novalidate>
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="w-full rounded-lg border-2 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-eg-moss
                              {{ $errors->has('email') ? 'border-eg-clay' : 'border-eg-dark/30' }}">
                @error('email')
                    <p role="alert" class="mt-1 text-sm text-eg-rust">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium">Kata sandi</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="w-full rounded-lg border-2 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-eg-moss
                              {{ $errors->has('password') ? 'border-eg-clay' : 'border-eg-dark/30' }}">
                @error('password')
                    <p role="alert" class="mt-1 text-sm text-eg-rust">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-eg-dark/40 text-eg-moss focus:ring-eg-moss">
                Ingat saya
            </label>

            <button type="submit"
                    class="w-full rounded-lg bg-gradient-to-r from-[#9FDB8E] to-eg-moss py-3 text-lg font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark focus-visible:ring-offset-2">
                Masuk
            </button>
        </form>
    </main>
</body>
</html>