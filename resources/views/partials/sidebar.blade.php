@php
    $menus = [
        ['label' => 'Beranda',    'icon' => 'home',     'route' => 'dashboard',      'active' => 'dashboard'],
        ['label' => 'Batch',      'icon' => 'batch',    'route' => 'batches.index',  'active' => 'batches.*'],
        ['label' => 'Pengaturan', 'icon' => 'settings', 'route' => 'settings.index', 'active' => 'settings.*'],
    ];
@endphp

<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full bg-gradient-to-b from-eg-leaf via-[#3FA032] to-eg-deep text-white transition-transform duration-200 lg:translate-x-0">

    {{-- Logo --}}
    <div class="flex h-[110px] items-center justify-center border-b-[3px] border-white/90 px-4">
        <a href="{{ route('dashboard') }}" aria-label="Eceng Gondok — ke Beranda">
            {{-- Ganti dengan <img src="{{ asset('images/logo-eceng-gondok.svg') }}"> bila aset logo tersedia --}}
            <span class="block -skew-x-6 text-[26px] font-bold italic leading-none tracking-tight drop-shadow-[0_2px_0_rgba(0,0,0,.15)]">
                ECENG GONDOK
            </span>
        </a>
    </div>

    {{-- Navigasi --}}
    <nav class="mt-7 space-y-1 px-2.5" aria-label="Menu utama">
        @foreach ($menus as $menu)
            @php
                $isActive = request()->routeIs($menu['active']);
                $href = Route::has($menu['route']) ? route($menu['route']) : '#';
            @endphp
            <a href="{{ $href }}"
               @if ($isActive) aria-current="page" @endif
               class="flex items-center gap-3 rounded-lg px-3 py-3 text-lg transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white
                      {{ $isActive ? 'bg-eg-mint font-medium text-white' : 'text-white hover:bg-white/15' }}">
                <x-icon :name="$menu['icon']" class="h-7 w-7 shrink-0" />
                <span>{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>