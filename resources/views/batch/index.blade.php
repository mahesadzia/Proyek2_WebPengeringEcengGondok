@extends('layouts.batch')

@section('title', 'Batch Pengeringan')
@section('page-title', 'Batch Pengeringan')

@section('content')
<div x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }" @keydown.escape.window="open = false">

    {{-- Tombol Tambah Batch --}}
    <div class="mb-6 flex justify-end">
        <button type="button" @click="open = true"
                class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-green-500 to-green-700 px-5 py-2 text-sm font-medium text-white shadow transition hover:brightness-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-700 focus-visible:ring-offset-2">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Batch
        </button>
    </div>

    {{-- Grid kartu batch (2 kolom) --}}
    <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-2">
        @forelse ($batches as $batch)
            @php
                $sesi    = $batch->activeSession;
                $aktif   = $sesi !== null;
                $progres = $aktif ? max(0, min(100, $sesi->progres)) : 0;
                $fmtKg   = fn ($v) => rtrim(rtrim(number_format($v, 2, ',', '.'), '0'), ',') . 'Kg';
            @endphp

            <article class="rounded-xl border-2 p-4 shadow-sm
                {{ $aktif
                    ? 'border-green-700 bg-gradient-to-br from-white to-green-200 text-green-800'
                    : 'border-red-700 bg-gradient-to-br from-red-100 to-white text-red-800' }}">

                {{-- Header --}}
                <header class="flex items-end justify-between border-b border-current pb-0.5">
                    <h2 class="text-lg font-semibold italic">{{ $batch->nama }}</h2>
                    <span class="text-lg italic">{{ $aktif ? 'Aktif' : 'Non Aktif' }}</span>
                </header>

                <dl class="mt-2 space-y-1 text-xs">
                    <div>
                        <dt class="font-semibold">Waktu Mulai Pengeringan:</dt>
                        <dd>
                            @if ($aktif)
                                {{ $sesi->waktu_mulai->format('d/m/Y') }} Pukul {{ $sesi->waktu_mulai->format('H.i') }} WIB
                            @else
                                --/--/---- Pukul -.- WIB
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-semibold">Bobot Awal:</dt>
                        <dd>{{ $aktif ? $fmtKg($sesi->bobot_awal) : '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-semibold">Bobot Akhir:</dt>
                        <dd class="italic">
                            @if (! $aktif)
                                -
                            @elseif ($sesi->bobot_akhir !== null)
                                {{ $fmtKg($sesi->bobot_akhir) }}
                            @else
                                menunggu...
                            @endif
                        </dd>
                    </div>
                </dl>

                {{-- Progres --}}
                <div class="mt-3 flex items-end justify-between text-base italic">
                    <span>Progres pengeringan</span>
                    <span>{{ $progres }}%</span>
                </div>
                <div class="mt-1 h-5 w-full overflow-hidden rounded-full bg-white shadow-inner"
                     role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $progres }}"
                     aria-label="Progres pengeringan {{ $batch->nama }}">
                    <div class="h-full rounded-full bg-green-800 transition-all duration-500" style="width: {{ $progres }}%"></div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-xl border-2 border-dashed border-green-300 p-10 text-center text-sm text-green-700">
                Belum ada batch. Klik <strong>Tambah Batch</strong> untuk membuat batch pertama.
            </div>
        @endforelse
    </div>

    {{-- Modal Tambah Batch --}}
    <div x-cloak x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="absolute inset-0 bg-black/50" @click="open = false"></div>

        <div x-show="open" x-transition class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <h3 id="modal-title" class="text-lg font-semibold text-green-800">Tambah Batch</h3>
                <button type="button" @click="open = false" class="rounded p-1 text-gray-500 hover:text-gray-700" aria-label="Tutup">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('batch.store') }}" class="mt-4 space-y-4">
                @csrf

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama batch</label>
                    <input id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="BCH5" required
                           class="mt-1 w-full rounded-lg border px-3 py-2 text-sm focus:border-green-600 focus:ring-green-600 @error('nama') border-red-500 @else border-gray-300 @enderror">
                    @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="bobot_awal" class="block text-sm font-medium text-gray-700">Bobot awal (Kg) <span class="font-normal text-gray-400">- opsional</span></label>
                    <input id="bobot_awal" name="bobot_awal" type="number" step="0.1" min="0" value="{{ old('bobot_awal') }}"
                           class="mt-1 w-full rounded-lg border px-3 py-2 text-sm focus:border-green-600 focus:ring-green-600 @error('bobot_awal') border-red-500 @else border-gray-300 @enderror">
                    @error('bobot_awal') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu mulai pengeringan <span class="font-normal text-gray-400">- wajib jika bobot diisi</span></label>
                    <input id="waktu_mulai" name="waktu_mulai" type="datetime-local" value="{{ old('waktu_mulai') }}"
                           class="mt-1 w-full rounded-lg border px-3 py-2 text-sm focus:border-green-600 focus:ring-green-600 @error('waktu_mulai') border-red-500 @else border-gray-300 @enderror">
                    @error('waktu_mulai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="open = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="rounded-lg bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-green-800">Simpan batch</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection