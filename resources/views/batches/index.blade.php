@extends('layouts.app')

@section('title', 'Batch')
@section('page-title', 'Batch Pengeringan')

@section('content')

<div class="flex justify-end">
    <button type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'tambah-batch')"
            class="inline-flex items-center gap-2 rounded-lg bg-eg-dark px-5 py-2.5 font-medium text-white hover:bg-eg-deep focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark focus-visible:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.2" stroke-linecap="round" class="h-4 w-4" aria-hidden="true">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        Tambah Batch
    </button>
</div>

    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
@forelse ($batches as $batch)
            @php
                $card  = $batch->is_active
                    ? 'border-eg-dark bg-gradient-to-br from-white via-eg-lime/50 to-eg-mint/70'
                    : 'border-eg-clay bg-gradient-to-br from-white via-eg-blush/40 to-eg-blush/80';
                $title = $batch->is_active ? 'text-eg-dark' : 'text-eg-rust';
                $track = $batch->is_active ? 'border-eg-dark/30' : 'border-eg-clay/30';
                $fill  = $batch->is_active ? 'bg-eg-dark' : 'bg-eg-clay';
            @endphp

            <article class="rounded-xl border p-5 shadow-sm {{ $card }}">

                <header class="flex items-baseline justify-between {{ $title }}">
                    <h2 class="text-xl font-bold italic">{{ $batch->nama }}</h2>
                    <span class="text-lg font-medium italic">{{ $batch->status_label }}</span>
                </header>

                <dl class="mt-4 space-y-1.5 text-sm text-eg-dark">
                    <div>
                        <dt class="font-semibold">Waktu Mulai Pengeringan:</dt>
                        <dd>{{ $batch->waktu_mulai_label }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-semibold">Bobot Awal:</dt>
                        <dd>{{ $batch->bobot_awal_label }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-semibold">Bobot Aktif:</dt>
                        <dd class="italic">{{ $batch->bobot_aktif_label }}</dd>
                    </div>
                </dl>

                <div class="mt-5 text-eg-dark">
                    <div class="flex justify-between italic">
                        <span>Progres pengeringan</span>
                        <span class="font-medium">{{ $batch->progres }}%</span>
                    </div>
                    <div class="mt-2 h-4 overflow-hidden rounded-full border bg-white {{ $track }}">
                        <div class="h-full rounded-full {{ $fill }}" style="width: {{ $batch->progres }}%"></div>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <a href="{{ route('batches.show', $batch) }}"
                       aria-label="Selengkapnya tentang {{ $batch->nama }}"
                       class="inline-flex items-center gap-1 text-sm font-semibold underline-offset-4 hover:underline {{ $title }}">
                        Selengkapnya <span aria-hidden="true">→</span>
                    </a>
                </div>

            </article>
        @empty
            <p class="text-eg-dark/70">Belum ada batch.</p>
        @endforelse

    </div>
    <x-modal name="tambah-batch" :show="$errors->tambahBatch->isNotEmpty()" maxWidth="md" focusable>
    <form method="POST" action="{{ route('batches.store') }}" class="p-6">
        @csrf

        <h2 class="text-xl font-bold text-eg-dark">Tambah Batch</h2>

        <div class="mt-5">
            <label for="nama" class="block text-sm font-semibold text-eg-dark">Nama Batch</label>
            <input id="nama" name="nama" type="text" value="{{ old('nama') }}" maxlength="50"
                   placeholder="Contoh: BCH5" autocomplete="off" required
                   class="mt-1.5 block w-full rounded-lg border-gray-300 uppercase shadow-sm focus:border-eg-dark focus:ring-eg-dark">
            @if ($errors->tambahBatch->has('nama'))
                <p class="mt-1.5 text-sm text-eg-rust" role="alert">{{ $errors->tambahBatch->first('nama') }}</p>
            @endif
        </div>

        <div class="mt-4">
            <label for="waktu_mulai" class="block text-sm font-semibold text-eg-dark">Waktu Mulai Pengeringan</label>
            <input id="waktu_mulai" name="waktu_mulai" type="datetime-local" value="{{ old('waktu_mulai') }}"
                   class="mt-1.5 block w-full rounded-lg border-gray-300 shadow-sm focus:border-eg-dark focus:ring-eg-dark">
            <p class="mt-1 text-xs text-gray-500">Dalam WIB. Kosongkan jika belum dimulai.</p>
            @if ($errors->tambahBatch->has('waktu_mulai'))
                <p class="mt-1.5 text-sm text-eg-rust" role="alert">{{ $errors->tambahBatch->first('waktu_mulai') }}</p>
            @endif
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" x-on:click="$dispatch('close')"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-eg-dark hover:bg-gray-50">
                Batal
            </button>
            <button type="submit"
                    class="rounded-lg bg-eg-dark px-5 py-2 font-medium text-white hover:bg-eg-deep">
                Simpan
            </button>
        </div>
    </form>
</x-modal>

@endsection