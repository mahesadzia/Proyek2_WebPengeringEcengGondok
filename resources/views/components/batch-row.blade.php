@props(['batch'])

@php
    // Kelas ditulis utuh (bukan dirangkai) agar terdeteksi oleh Tailwind saat build.
    $theme = $batch->is_active
        ? [
            'row'    => 'bg-green-50',
            'bar'    => 'bg-green-700',
            'name'   => 'text-green-900',
            'badge'  => 'bg-green-700 text-white',
            'action' => 'border-green-800 text-green-900 hover:bg-green-100 focus-visible:ring-green-800',
        ]
        : [
            'row'    => 'bg-red-50',
            'bar'    => 'bg-red-700',
            'name'   => 'text-red-900',
            'badge'  => 'bg-red-700 text-white',
            'action' => 'border-red-800 text-red-900 hover:bg-red-100 focus-visible:ring-red-800',
        ];

    $detailUrl = Route::has('batches.show') ? route('batches.show', $batch) : '#';
@endphp

<li class="relative flex flex-wrap items-center justify-between gap-x-6 gap-y-3 py-5 pl-8 pr-5 sm:pl-14 sm:pr-10 {{ $theme['row'] }}">
    <span class="absolute inset-y-0 left-0 w-2.5 {{ $theme['bar'] }}" aria-hidden="true"></span>
    <div class="flex min-w-0 flex-wrap items-center gap-x-5 gap-y-2">
        <span class="truncate text-2xl font-bold italic sm:text-[28px] {{ $theme['name'] }}">{{ $batch->nama }}</span>
        <span class="rounded-full px-4 py-1 text-base font-semibold {{ $theme['badge'] }}">{{ $batch->status_label }}</span>
    </div>

    <a href="{{ $detailUrl }}"
       aria-label="Detail {{ $batch->nama }}"
       class="inline-flex items-center gap-2 rounded-lg border-2 bg-white px-5 py-2.5 text-lg font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 {{ $theme['action'] }}">
        <x-icon name="search" class="h-5 w-5 shrink-0" />
        <span>Detail</span>
    </a>
</li>
