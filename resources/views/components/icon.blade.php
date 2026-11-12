@props(['name', 'class' => 'h-6 w-6'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
     {{ $attributes->merge(['class' => $class, 'aria-hidden' => 'true']) }}>
    @switch($name)
        @case('home')
            <path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9.5Z"/>
            @break

        @case('batch')
            {{-- Kubus (kotak 3D) --}}
            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
            <path d="m3.3 7 8.7 5 8.7-5"/>
            <path d="M12 22V12"/>
            @break

        @case('settings')
            {{-- Slider --}}
            <path d="M4 7h9M17 7h3M4 17h3M11 17h9"/>
            <circle cx="15" cy="7" r="2"/>
            <circle cx="9" cy="17" r="2"/>
            @break

        @case('user')
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/>
            @break

        @case('search')
            <circle cx="10.5" cy="10.5" r="6.5" stroke-width="3"/>
            <path d="m15.5 15.5 5 5" stroke-width="3"/>
            @break

        @case('menu')
            <path d="M4 6h16M4 12h16M4 18h16"/>
            @break

        @case('logout')
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
            @break
    @endswitch
</svg>