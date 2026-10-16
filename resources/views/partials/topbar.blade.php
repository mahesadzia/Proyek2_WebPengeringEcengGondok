<header class="flex h-[110px] items-center justify-between border-b-[3px] border-gray-300 px-5 sm:px-8">
    <div class="flex items-center gap-3">
        <button id="sidebar-toggle" type="button" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu"
                class="rounded-md p-2 text-eg-dark hover:bg-eg-lime/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark lg:hidden">
            <x-icon name="menu" />
        </button>
        <h1 class="text-3xl font-bold tracking-tight">{{ $pageTitle }}</h1>
    </div>

    {{-- Menu akun (tanpa JS, memakai <details>) --}}
    <details class="group relative">
        <summary
            class="flex cursor-pointer list-none items-center gap-2 rounded-lg bg-gradient-to-r from-[#9FDB8E] to-eg-moss px-6 py-3 text-lg text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark [&::-webkit-details-marker]:hidden">
            <x-icon name="user" class="h-7 w-7" />
            <span>Akun</span>
        </summary>

        <div class="absolute right-0 z-20 mt-2 w-56 rounded-lg border border-eg-dark/20 bg-white p-2 shadow-lg">
            <p class="truncate px-3 py-2 text-sm text-eg-dark/70">{{ auth()->user()->name ?? 'Pengguna' }}</p>

            @if (Route::has('logout'))
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-eg-rust hover:bg-eg-blush/40">
                        <x-icon name="logout" class="h-5 w-5" />
                        Keluar
                    </button>
                </form>
            @endif
        </div>
    </details>
</header>