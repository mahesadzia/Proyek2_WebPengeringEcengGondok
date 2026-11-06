<header class="flex h-[110px] items-center justify-between gap-4 border-b-[3px] border-gray-300 px-5 sm:px-8">
    <div class="flex min-w-0 items-center gap-3">
        <button id="sidebar-toggle" type="button" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu"
                class="rounded-md p-2 text-eg-dark hover:bg-green-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark lg:hidden">
            <x-icon name="menu" />
        </button>
        <h1 class="truncate text-2xl font-bold tracking-tight sm:text-3xl">{{ $pageTitle }}</h1>
    </div>

    {{-- Menu akun (tanpa JS, memakai <details>) --}}
    <details class="group relative shrink-0">
        <summary
            class="flex cursor-pointer list-none items-center gap-2 rounded-lg bg-eg-dark px-5 py-2.5 text-base font-medium text-white shadow-sm hover:bg-eg-deep focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark focus-visible:ring-offset-2 [&::-webkit-details-marker]:hidden">
            <x-icon name="user" class="h-6 w-6" />
            <span class="hidden sm:inline">Akun</span>
            <span class="sr-only sm:hidden">Akun</span>
        </summary>

        <div class="absolute right-0 z-20 mt-2 w-60 rounded-lg border border-gray-200 bg-white p-2 shadow-lg">
            <p class="truncate px-3 py-2 text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'Pengguna' }}</p>

            @if (Route::has('logout'))
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left font-medium text-red-800 hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-700">
                        <x-icon name="logout" class="h-5 w-5" />
                        Keluar
                    </button>
                </form>
            @endif
        </div>
    </details>
</header>
