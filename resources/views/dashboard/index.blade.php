@extends('layouts.app')

@section('title', 'Beranda')
@section('page-title', 'Beranda')

@section('content')
    @php
        $tanggal = now('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y');

        if ($ringkasan['aktif'] === 0) {
            $kalimat = 'Belum ada batch yang sedang berjalan.';
        } else {
            $kalimat = $ringkasan['aktif'] . ' batch sedang berjalan'
                . ($ringkasan['selesai'] > 0 ? ', ' . $ringkasan['selesai'] . ' sudah mencapai 100%' : '')
                . '.';
        }

        $kartu = [
            ['Total batch',  $ringkasan['total'],    'terdaftar di sistem'],
            ['Batch aktif',  $ringkasan['aktif'],    'sedang berjalan'],
            ['Non aktif',    $ringkasan['nonaktif'], 'tidak berjalan'],
        ];
    @endphp

    {{-- Sapaan --}}
    <h2 class="text-[28px] font-semibold tracking-tight text-ec-ink">
        Selamat datang, {{ auth()->user()->name ?? 'Pengguna' }}
    </h2>
    <p class="mt-1 text-sm text-ec-ink/70">{{ $tanggal }} · {{ $kalimat }}</p>

    {{-- Kartu ringkasan --}}
    <dl class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ($kartu as [$label, $angka, $keterangan])
            <div class="rounded-2xl border border-ec-line bg-white p-5 shadow-sm">
                <dt class="text-sm text-ec-ink/70">{{ $label }}</dt>
                <dd class="mt-1 text-4xl font-bold text-ec-ink">{{ $angka }}</dd>
                <dd class="mt-1 text-sm text-ec-ink/70">{{ $keterangan }}</dd>
            </div>
        @endforeach

        <div class="rounded-2xl border border-ec-line bg-white p-5 shadow-sm">
            <dt class="text-sm text-ec-ink/70">Rata-rata progres</dt>
            <dd class="mt-1 text-4xl font-bold text-ec-ink">{{ $ringkasan['rata'] }}%</dd>
            <dd class="mt-1 text-sm text-ec-ink/70">dari batch aktif</dd>
            <dd class="mt-3 h-2 overflow-hidden rounded-full bg-ec-sand" role="progressbar"
                aria-label="Rata-rata progres batch aktif" aria-valuenow="{{ $ringkasan['rata'] }}"
                aria-valuemin="0" aria-valuemax="100">
                <span class="block h-full rounded-full bg-ec-leaf" style="width: {{ $ringkasan['rata'] }}%"></span>
            </dd>
        </div>
    </dl>

    {{-- Monitoring sensor ESP32 --}}
    <section class="mt-5 rounded-2xl border border-ec-line bg-white p-6 shadow-sm" aria-labelledby="judul-sensor">
        <div class="flex flex-wrap items-center justify-between gap-2">
            <div>
                <h3 id="judul-sensor" class="text-xl font-semibold text-ec-ink">Monitoring sensor</h3>
                <p class="mt-0.5 text-sm text-ec-ink/70">
                    Perangkat: <span class="font-medium text-ec-ink">{{ $latestSensor->kode_perangkat ?? 'Belum ada data' }}</span>
                    @if ($latestSensor)
                        · Update terakhir {{ $latestSensor->created_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </div>

        @if ($latestSensor)
            <dl class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
                <div class="rounded-xl border border-ec-line bg-ec-cream/50 p-4">
                    <dt class="text-xs text-ec-ink/70">Suhu</dt>
                    <dd class="mt-1 text-2xl font-bold text-ec-ink">{{ number_format($latestSensor->suhu, 1) }} °C</dd>
                </div>
                <div class="rounded-xl border border-ec-line bg-ec-cream/50 p-4">
                    <dt class="text-xs text-ec-ink/70">Kelembaban</dt>
                    <dd class="mt-1 text-2xl font-bold text-ec-ink">{{ number_format($latestSensor->kelembaban, 1) }} %</dd>
                </div>
                <div class="rounded-xl border border-ec-line bg-ec-cream/50 p-4">
                    <dt class="text-xs text-ec-ink/70">Heater</dt>
                    <dd class="mt-1 text-lg font-semibold text-ec-ink">{{ $latestSensor->heater ? 'ON' : 'OFF' }}</dd>
                </div>
                <div class="rounded-xl border border-ec-line bg-ec-cream/50 p-4">
                    <dt class="text-xs text-ec-ink/70">Kipas</dt>
                    <dd class="mt-1 text-lg font-semibold text-ec-ink">{{ $latestSensor->kipas ? 'ON' : 'OFF' }}</dd>
                </div>
            </dl>

            @if (isset($recentSensors) && $recentSensors->isNotEmpty())
                <div class="mt-5 overflow-x-auto border-t border-ec-line pt-4">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-ec-line text-ec-ink/70">
                                <th class="pb-2 font-medium">Waktu</th>
                                <th class="pb-2 font-medium">Perangkat</th>
                                <th class="pb-2 font-medium">Suhu (°C)</th>
                                <th class="pb-2 font-medium">Kelembaban (%)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ec-line">
                            @foreach ($recentSensors as $row)
                                <tr>
                                    <td class="py-2.5 text-ec-ink/80">{{ $row->created_at->format('H:i:s') }}</td>
                                    <td class="py-2.5 font-medium text-ec-ink">{{ $row->kode_perangkat }}</td>
                                    <td class="py-2.5 text-ec-ink">{{ number_format($row->suhu, 1) }}</td>
                                    <td class="py-2.5 text-ec-ink">{{ number_format($row->kelembaban, 1) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @else
            <p class="mt-4 rounded-xl bg-ec-cream px-4 py-6 text-center text-sm text-ec-ink/70">
                Belum ada data sensor masuk dari ESP32.
            </p>
        @endif
    </section>

    <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1.85fr)_minmax(0,1fr)]">

        {{-- Status batch --}}
        <section class="rounded-2xl border border-ec-line bg-white p-6 shadow-sm" aria-labelledby="judul-status">
            <div class="flex items-center justify-between gap-4">
                <h3 id="judul-status" class="text-xl font-semibold text-ec-ink">Status batch</h3>
                <a href="{{ route('batches.index') }}"
                   class="text-sm font-medium text-ec-moss hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest">
                    Kelola batch →
                </a>
            </div>

            @if ($batches->isNotEmpty())
                <ul class="mt-4 divide-y divide-ec-line border-t border-ec-line">
                    @foreach ($batches as $batch)
                        @php $progres = max(0, min(100, (int) $batch->progres)); @endphp
                        <li class="flex flex-wrap items-center gap-x-3 gap-y-2 py-3.5 sm:flex-nowrap sm:gap-x-4">
                            <span class="w-12 shrink-0 font-semibold text-ec-ink sm:w-14">{{ $batch->nama }}</span>

                            <span class="inline-flex shrink-0 sm:w-28">
                                @if ($batch->is_active)
                                    <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full bg-ec-sage px-3 py-1 text-sm font-medium text-ec-moss">
                                        <span class="h-1.5 w-1.5 rounded-full bg-ec-leaf" aria-hidden="true"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full bg-ec-rose px-3 py-1 text-sm font-medium text-ec-rosetext">
                                        <span class="h-1.5 w-1.5 rounded-full bg-ec-rosetext" aria-hidden="true"></span>
                                        Non Aktif
                                    </span>
                                @endif
                            </span>

                            <div class="order-last h-2 basis-full overflow-hidden rounded-full bg-ec-sand sm:order-none sm:min-w-[3rem] sm:flex-1 sm:basis-0" role="progressbar"
                                 aria-label="Progres {{ $batch->nama }}" aria-valuenow="{{ $progres }}"
                                 aria-valuemin="0" aria-valuemax="100">
                                <div class="h-full rounded-full bg-ec-leaf" style="width: {{ $progres }}%"></div>
                            </div>

                            <span class="ml-auto w-12 shrink-0 text-right text-sm font-semibold text-ec-ink sm:ml-0">{{ $progres }}%</span>

                            <a href="{{ route('batches.show', $batch) }}" aria-label="Detail {{ $batch->nama }}"
                               class="shrink-0 text-sm font-medium text-ec-moss hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest">
                                Detail
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-4 rounded-xl bg-ec-cream px-4 py-8 text-center text-sm text-ec-ink/70">
                    Belum ada batch. <a href="{{ route('batches.index') }}" class="font-medium text-ec-moss underline">Tambah batch</a>
                </p>
            @endif
        </section>

        {{-- Perlu perhatian --}}
        <section class="rounded-2xl border border-ec-line bg-white p-6 shadow-sm" aria-labelledby="judul-perhatian">
            <h3 id="judul-perhatian" class="text-xl font-semibold text-ec-ink">Perlu perhatian</h3>

            <div class="mt-4 space-y-3">
                @forelse ($perhatian as $batch)
                    <article class="rounded-xl border border-ec-amberline bg-ec-amber p-4 text-ec-amberink">
                        @if ($batch->progres >= 100)
                            <h4 class="font-semibold">{{ $batch->nama }} sudah 100%</h4>
                            <p class="mt-1 text-sm leading-relaxed">
                                Pengeringan selesai, tetapi batch masih aktif. Nonaktifkan atau catat bobot akhir.
                            </p>
                        @else
                            <h4 class="font-semibold">{{ $batch->nama }} hampir selesai</h4>
                            <p class="mt-1 text-sm leading-relaxed">
                                Progres {{ $batch->progres }}%,
                                @if ($batch->bobot_aktif !== null)
                                    bobot aktif {{ $batch->bobot_aktif_label }}.
                                @else
                                    bobot aktif belum terbaca.
                                @endif
                            </p>
                        @endif
                        <a href="{{ route('batches.show', $batch) }}"
                           class="mt-3 inline-block text-sm font-semibold underline underline-offset-2 hover:no-underline">
                            Buka batch
                        </a>
                    </article>
                @empty
                    <p class="rounded-xl bg-ec-sage/60 px-4 py-5 text-sm text-ec-moss">
                        Semua batch berjalan normal. Tidak ada yang perlu diperhatikan.
                    </p>
                @endforelse
            </div>
        </section>
    </div>
@endsection