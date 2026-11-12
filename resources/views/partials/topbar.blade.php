<header class="flex h-[88px] items-center justify-between border-b border-ec-line bg-white/50 px-5 sm:px-10">
    <div class="flex items-center gap-3">
        <button id="sidebar-toggle" type="button" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu"
                class="rounded-md p-2 text-ec-ink hover:bg-ec-sage focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest lg:hidden">
            <x-icon name="menu" />
        </button>
        <h1 class="text-[26px] font-semibold tracking-tight text-ec-ink">{{ $pageTitle }}</h1>
    </div>

    {{-- Menu akun (tanpa JS, memakai <details>) --}}
    <details class="group relative">
        <summary
            class="flex cursor-pointer list-none items-center gap-2 rounded-lg border border-ec-line bg-white px-4 py-2.5 text-sm font-medium text-ec-ink shadow-sm hover:bg-ec-cream focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest [&::-webkit-details-marker]:hidden">
            <x-icon name="user" class="h-5 w-5" />
            <span>Akun</span>
        </summary>

        <div class="absolute right-0 z-20 mt-2 w-56 rounded-xl border border-ec-line bg-white p-2 shadow-lg">
            <p class="truncate px-3 py-2 text-sm text-ec-ink/70">{{ auth()->user()->name ?? 'Pengguna' }}</p>

            @if (Route::has('logout'))
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-ec-rosetext hover:bg-ec-rose/60">
                        <x-icon name="logout" class="h-5 w-5" />
                        Keluar
                    </button>
                </form>
            @endif
        </div>
    </details>
</header>
