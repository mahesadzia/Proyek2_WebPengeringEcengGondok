@php
    $menus = [
        ['label' => 'Beranda',    'icon' => 'home',     'route' => 'dashboard',        'active' => 'dashboard'],
        ['label' => 'Batch',      'icon' => 'batch',    'route' => 'batches.index',    'active' => 'batches.*'],
        ['label' => 'Pengaturan', 'icon' => 'settings', 'route' => 'pengaturan.index', 'active' => 'pengaturan.*'],
    ];
@endphp

<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full bg-gradient-to-b from-[#2F7D26] via-[#256B1F] to-eg-deep text-white shadow-xl transition-transform duration-200 lg:translate-x-0 lg:shadow-none">

    {{-- Logo --}}
    <div class="flex h-[110px] items-center justify-center border-b-[3px] border-white/90 px-4">
        <a href="{{ route('dashboard') }}" aria-label="Eceng Gondok — ke Beranda"
           class="rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#2F7D26]">
            {{-- Ganti dengan <img src="{{ asset('images/logo-eceng-gondok.svg') }}"> bila aset logo tersedia --}}
            <span class="block -skew-x-6 text-[26px] font-bold italic leading-none tracking-tight drop-shadow-[0_2px_0_rgba(0,0,0,.25)]">
                ECENG GONDOK
            </span>
        </a>
    </div>

    {{-- Navigasi --}}
    <nav class="mt-7 space-y-1.5 px-3" aria-label="Menu utama">
        @foreach ($menus as $menu)
            @php
                $isActive = request()->routeIs($menu['active']);
                $href = Route::has($menu['route']) ? route($menu['route']) : '#';
            @endphp
            <a href="{{ $href }}"
               @if ($isActive) aria-current="page" @endif
               class="flex items-center gap-3 rounded-lg px-4 py-3 text-lg transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white
                      {{ $isActive ? 'bg-white font-semibold text-eg-dark shadow-sm' : 'font-medium text-white hover:bg-white/15' }}">
                <x-icon :name="$menu['icon']" class="h-6 w-6 shrink-0" />
                <span>{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>
