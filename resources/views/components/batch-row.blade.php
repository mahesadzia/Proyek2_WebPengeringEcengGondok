@props(['batch'])

@php
    // Kelas ditulis utuh (bukan dirangkai) agar terdeteksi oleh Tailwind saat build.
    $theme = $batch->is_active
        ? [
            'main'   => 'bg-gradient-to-r from-eg-lime from-10% to-eg-moss',
            'detail' => 'bg-gradient-to-br from-eg-lime from-55% to-eg-moss',
            'name'   => 'text-eg-dark',
            'action' => 'text-eg-dark',
            'focus'  => 'focus-visible:ring-eg-dark',
        ]
        : [
            'main'   => 'bg-gradient-to-r from-eg-blush from-10% to-eg-clay',
            'detail' => 'bg-gradient-to-br from-eg-blush from-55% to-eg-clay',
            'name'   => 'text-eg-rust',
            'action' => 'text-eg-rust',
            'focus'  => 'focus-visible:ring-eg-rust',
        ];

    $detailUrl = Route::has('batches.show') ? route('batches.show', $batch) : '#';
@endphp

<li class="flex border-t border-white first:border-t-0">
    {{-- Nama batch & status --}}
    <div class="flex min-w-0 flex-1 items-center justify-between gap-4 px-5 py-6 sm:px-12 sm:py-7 {{ $theme['main'] }}">
        <span class="truncate text-2xl font-medium italic sm:text-[28px] {{ $theme['name'] }}">{{ $batch->nama }}</span>
        <span class="shrink-0 text-2xl font-medium italic text-white sm:text-[28px]">{{ $batch->status_label }}</span>
    </div>

    {{-- Tombol detail --}}
    <a href="{{ $detailUrl }}"
       aria-label="Detail {{ $batch->nama }}"
       class="flex w-28 shrink-0 items-center justify-center gap-1.5 px-3 text-lg font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-inset sm:w-[163px] {{ $theme['detail'] }} {{ $theme['action'] }} {{ $theme['focus'] }}">
        <x-icon name="search" class="h-8 w-8 shrink-0" />
        <span>Detail</span>
    </a>
</li>