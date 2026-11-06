@extends('layouts.app')

@section('title', 'Detail ' . $batch->nama)
@section('page-title', 'Detail Batch')

@section('content')
    @php
        // Kelas ditulis utuh (bukan dirangkai) agar terdeteksi oleh Tailwind saat build.
        $theme = $batch->is_active
            ? [
                'card'  => 'border-green-700 bg-green-50',
                'title' => 'text-green-900',
                'badge' => 'bg-green-700 text-white',
                'track' => 'border-green-700/50',
                'fill'  => 'bg-green-700',
            ]
            : [
                'card'  => 'border-red-700 bg-red-50',
                'title' => 'text-red-900',
                'badge' => 'bg-red-700 text-white',
                'track' => 'border-red-700/50',
                'fill'  => 'bg-red-700',
            ];

        $progres = max(0, min(100, (int) $batch->progres));

        $info = [
            'Waktu Mulai Pengeringan' => $batch->waktu_mulai_label,
            'Durasi Berjalan'         => $batch->durasi_label,
            'Bobot Awal'              => $batch->bobot_awal_label,
            'Bobot Aktif'             => $batch->bobot_aktif_label,
            'Susut Bobot'             => $batch->susut_bobot_label,
            'Status'                  => $batch->status_label,
        ];

        $sensor = [
            ['Suhu', '- °C'],
            ['Kelembaban', '- %'],
            ['Heater', '-'],
            ['Kipas Exhaust', '-'],
        ];
    @endphp

    <a href="{{ route('batches.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-eg-dark hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark">
        <span aria-hidden="true">←</span> Kembali ke daftar batch
    </a>

    {{-- Ringkasan: nama, status, progres --}}
    <section class="mt-4 rounded-2xl border p-6 shadow-sm sm:p-8 {{ $theme['card'] }}">
        <header class="flex items-baseline justify-between gap-4 {{ $theme['title'] }}">
            <h2 class="truncate text-3xl font-bold italic">{{ $batch->nama }}</h2>
            <span class="shrink-0 rounded-full px-4 py-1 text-lg font-semibold {{ $theme['badge'] }}">{{ $batch->status_label }}</span>
        </header>

        <div class="mt-6 text-gray-900">
            <div class="flex items-baseline justify-between text-lg">
                <span>Progres pengeringan</span>
                <span class="text-2xl font-bold">{{ $progres }}%</span>
            </div>
            <div role="progressbar" aria-label="Progres pengeringan {{ $batch->nama }}"
                 aria-valuenow="{{ $progres }}" aria-valuemin="0" aria-valuemax="100"
                 class="mt-2 h-5 overflow-hidden rounded-full border bg-white {{ $theme['track'] }}">
                <div class="h-full rounded-full transition-all duration-500 {{ $theme['fill'] }}"
                     style="width: {{ $progres }}%"></div>
            </div>
        </div>
    </section>

    {{-- Informasi pengeringan --}}
    <section class="mt-6 rounded-2xl border border-gray-300 bg-white p-6 sm:p-8" aria-labelledby="judul-info">
        <h3 id="judul-info" class="text-xl font-bold text-eg-dark">Informasi Pengeringan</h3>

        <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($info as $label => $nilai)
                <div class="rounded-xl border border-green-700/20 bg-green-50 px-4 py-3">
                    <dt class="text-sm font-medium text-gray-700">{{ $label }}</dt>
                    <dd class="mt-0.5 text-lg font-semibold text-gray-900">{{ $nilai }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- Kondisi alat: terisi setelah ESP32 terhubung --}}
    <section class="mt-6 rounded-2xl border border-gray-300 bg-white p-6 sm:p-8" aria-labelledby="judul-sensor">
        <h3 id="judul-sensor" class="text-xl font-bold text-eg-dark">Kondisi Alat</h3>
        <p class="mt-1 text-sm text-gray-600">Menunggu data sensor dari alat. Nilai akan tampil otomatis setelah alat terhubung.</p>

        <dl class="mt-4 grid grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach ($sensor as [$label, $nilai])
                <div class="rounded-xl border border-gray-300 px-4 py-3 text-center">
                    <dt class="text-sm font-medium text-gray-700">{{ $label }}</dt>
                    <dd class="mt-1 text-2xl font-semibold text-gray-600">{{ $nilai }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- Riwayat pembacaan --}}
    <section class="mt-6 rounded-2xl border border-gray-300 bg-white p-6 sm:p-8" aria-labelledby="judul-riwayat">
        <h3 id="judul-riwayat" class="text-xl font-bold text-eg-dark">Riwayat Pembacaan</h3>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full min-w-[32rem] text-left text-base">
                <thead>
                    <tr class="border-b border-gray-300 text-gray-900">
                        <th scope="col" class="py-2 pr-4 font-semibold">Waktu</th>
                        <th scope="col" class="py-2 pr-4 font-semibold">Suhu</th>
                        <th scope="col" class="py-2 pr-4 font-semibold">Kelembaban</th>
                        <th scope="col" class="py-2 font-semibold">Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-600">Belum ada data pembacaan untuk batch ini.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Catatan data --}}
    <p class="mt-6 text-sm text-gray-600">
        Dibuat {{ $batch->created_at->timezone('Asia/Jakarta')->format('d/m/Y H.i') }} WIB
        · Terakhir diperbarui {{ $batch->updated_at->timezone('Asia/Jakarta')->format('d/m/Y H.i') }} WIB
    </p>
@endsection