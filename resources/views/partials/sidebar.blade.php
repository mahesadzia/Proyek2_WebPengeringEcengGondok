@php
    $menus = [
        ['label' => 'Beranda',    'icon' => 'home',     'route' => 'dashboard',        'active' => 'dashboard'],
        ['label' => 'Batch',      'icon' => 'batch',    'route' => 'batches.index',    'active' => 'batches.*'],
        ['label' => 'Pengaturan', 'icon' => 'settings', 'route' => 'pengaturan.index', 'active' => 'pengaturan.*'],
    ];
@endphp

<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 w-60 -translate-x-full bg-ec-forest text-white transition-transform duration-200 lg:translate-x-0">

    {{-- Logo --}}
    <div class="flex h-[88px] items-center border-b border-white/10 px-7">
        <a href="{{ route('dashboard') }}" aria-label="Eceng Gondok — ke Beranda"
           class="text-lg font-bold tracking-wide focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
            ECENG GONDOK
        </a>
    </div>

    {{-- Navigasi --}}
    <nav class="mt-5 space-y-1.5 px-3.5" aria-label="Menu utama">
        @foreach ($menus as $menu)
            @php
                $isActive = request()->routeIs($menu['active']);
                $href = Route::has($menu['route']) ? route($menu['route']) : '#';
            @endphp
            <a href="{{ $href }}"
               @if ($isActive) aria-current="page" @endif
               class="flex items-center gap-3 rounded-xl px-3.5 py-3 text-[15px] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white
                      {{ $isActive ? 'bg-ec-mist font-medium text-ec-forest' : 'text-white/90 hover:bg-white/10' }}">
                <x-icon :name="$menu['icon']" class="h-5 w-5 shrink-0" />
                <span>{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>
