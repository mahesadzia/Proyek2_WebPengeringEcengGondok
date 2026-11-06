@extends('layouts.app')

@section('title', 'Batch')
@section('page-title', 'Batch Pengeringan')

@section('content')

{{-- Wrapper: menyimpan batch yang sedang dipilih untuk modal konfirmasi (nonaktifkan / hapus) --}}
<div x-data="{ target: { nama: '', aktif: false, statusUrl: '', hapusUrl: '' } }">

    <div class="flex justify-end">
        <button type="button" x-on:click.prevent="$dispatch('open-modal', 'tambah-batch')"
                class="inline-flex items-center gap-2 rounded-lg bg-eg-dark px-5 py-2.5 font-medium text-white shadow-sm hover:bg-eg-deep focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark focus-visible:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.2" stroke-linecap="round" class="h-5 w-5" aria-hidden="true">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Batch
        </button>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">
        @forelse ($batches as $batch)
            @php
                // Kelas ditulis utuh (bukan dirangkai) agar terdeteksi oleh Tailwind saat build.
                $theme = $batch->is_active
                    ? [
                        'card'  => 'border-green-700 bg-green-50',
                        'title' => 'text-green-900',
                        'badge' => 'bg-green-700 text-white',
                        'track' => 'border-green-700/50',
                        'fill'  => 'bg-green-700',
                        'line'  => 'border-green-700/30',
                        'link'  => 'text-green-900 focus-visible:ring-green-800',
                    ]
                    : [
                        'card'  => 'border-red-700 bg-red-50',
                        'title' => 'text-red-900',
                        'badge' => 'bg-red-700 text-white',
                        'track' => 'border-red-700/50',
                        'fill'  => 'bg-red-700',
                        'line'  => 'border-red-700/30',
                        'link'  => 'text-red-900 focus-visible:ring-red-800',
                    ];

                $progres = max(0, min(100, (int) $batch->progres));
            @endphp

            <article class="flex flex-col rounded-xl border-2 p-5 shadow-sm sm:p-6 {{ $theme['card'] }}">

                <header class="flex items-center justify-between gap-3 {{ $theme['title'] }}">
                    <h2 class="truncate text-2xl font-bold italic">{{ $batch->nama }}</h2>
                    <span class="shrink-0 rounded-full px-4 py-1 text-base font-semibold {{ $theme['badge'] }}">{{ $batch->status_label }}</span>
                </header>

                <dl class="mt-4 space-y-2 text-base text-gray-900">
                    <div>
                        <dt class="font-semibold">Waktu Mulai Pengeringan</dt>
                        <dd>{{ $batch->waktu_mulai_label }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="font-semibold">Bobot Awal</dt>
                        <dd>{{ $batch->bobot_awal_label }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="font-semibold">Bobot Aktif</dt>
                        <dd class="italic">{{ $batch->bobot_aktif_label }}</dd>
                    </div>
                </dl>

                <div class="mt-5 text-gray-900">
                    <div class="flex items-baseline justify-between">
                        <span class="font-medium">Progres pengeringan</span>
                        <span class="text-xl font-bold">{{ $progres }}%</span>
                    </div>
                    <div role="progressbar" aria-label="Progres pengeringan {{ $batch->nama }}"
                         aria-valuenow="{{ $progres }}" aria-valuemin="0" aria-valuemax="100"
                         class="mt-2 h-4 overflow-hidden rounded-full border bg-white {{ $theme['track'] }}">
                        <div class="h-full rounded-full transition-all duration-500 {{ $theme['fill'] }}"
                             style="width: {{ $progres }}%"></div>
                    </div>
                </div>

                {{-- Aksi: aktif/nonaktif, hapus, detail --}}
                <div class="mt-5 flex flex-wrap items-center gap-2 border-t pt-4 {{ $theme['line'] }}">
                    @if ($batch->is_active)
                        <button type="button"
                                aria-label="Nonaktifkan {{ $batch->nama }}"
                                x-on:click="target = { nama: @js($batch->nama), aktif: true, statusUrl: @js(route('batches.status', $batch)), hapusUrl: @js(route('batches.destroy', $batch)) }; $dispatch('open-modal', 'nonaktif-batch')"
                                class="inline-flex items-center gap-2 rounded-lg border-2 border-gray-500 bg-white px-4 py-2 font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-700 focus-visible:ring-offset-2">
                            <x-icon name="power" class="h-5 w-5" />
                            Nonaktifkan
                        </button>
                    @else
                        <form method="POST" action="{{ route('batches.status', $batch) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    aria-label="Aktifkan {{ $batch->nama }}"
                                    class="inline-flex items-center gap-2 rounded-lg bg-eg-dark px-4 py-2 font-medium text-white hover:bg-eg-deep focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark focus-visible:ring-offset-2">
                                <x-icon name="power" class="h-5 w-5" />
                                Aktifkan
                            </button>
                        </form>
                    @endif

                    <button type="button"
                            aria-label="Hapus {{ $batch->nama }}"
                            x-on:click="target = { nama: @js($batch->nama), aktif: @js((bool) $batch->is_active), statusUrl: @js(route('batches.status', $batch)), hapusUrl: @js(route('batches.destroy', $batch)) }; $dispatch('open-modal', 'hapus-batch')"
                            class="inline-flex items-center gap-2 rounded-lg border-2 border-red-700 bg-white px-4 py-2 font-medium text-red-800 hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-700 focus-visible:ring-offset-2">
                        <x-icon name="trash" class="h-5 w-5" />
                        Hapus
                    </button>

                    <a href="{{ route('batches.show', $batch) }}"
                       aria-label="Selengkapnya tentang {{ $batch->nama }}"
                       class="ml-auto inline-flex items-center gap-1 rounded font-semibold underline-offset-4 hover:underline focus:outline-none focus-visible:ring-2 {{ $theme['link'] }}">
                        Selengkapnya <span aria-hidden="true">→</span>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-xl border-2 border-dashed border-green-700/50 bg-green-50 px-6 py-12 text-center text-green-900">
                <p class="text-lg font-semibold">Belum ada batch.</p>
                <p class="mt-1">Klik <strong>Tambah Batch</strong> untuk membuat batch pertama.</p>
            </div>
        @endforelse
    </div>

    {{-- Modal: tambah batch --}}
    <x-modal name="tambah-batch" :show="$errors->tambahBatch->isNotEmpty()" maxWidth="md" focusable>
        <form method="POST" action="{{ route('batches.store') }}" class="p-6">
            @csrf

            <h2 class="text-xl font-bold text-eg-dark">Tambah Batch</h2>

            <div class="mt-5">
                <label for="nama" class="block font-semibold text-gray-900">Nama Batch</label>
                <input id="nama" name="nama" type="text" value="{{ old('nama') }}" maxlength="50"
                       placeholder="Contoh: BCH5" autocomplete="off" required
                       class="mt-1.5 block w-full rounded-lg border-gray-400 uppercase shadow-sm placeholder:text-gray-500 focus:border-eg-dark focus:ring-eg-dark">
                @if ($errors->tambahBatch->has('nama'))
                    <p class="mt-1.5 text-sm font-medium text-red-800" role="alert">{{ $errors->tambahBatch->first('nama') }}</p>
                @endif
            </div>

            <div class="mt-4">
                <label for="waktu_mulai" class="block font-semibold text-gray-900">Waktu Mulai Pengeringan</label>
                <input id="waktu_mulai" name="waktu_mulai" type="datetime-local" value="{{ old('waktu_mulai') }}"
                       class="mt-1.5 block w-full rounded-lg border-gray-400 shadow-sm focus:border-eg-dark focus:ring-eg-dark">
                <p class="mt-1 text-sm text-gray-600">Dalam WIB. Kosongkan jika belum dimulai.</p>
                @if ($errors->tambahBatch->has('waktu_mulai'))
                    <p class="mt-1.5 text-sm font-medium text-red-800" role="alert">{{ $errors->tambahBatch->first('waktu_mulai') }}</p>
                @endif
            </div>

            <label class="mt-5 flex cursor-pointer items-start gap-3">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active'))
                       class="mt-1 h-5 w-5 rounded border-gray-500 text-eg-dark focus:ring-eg-dark">
                <span>
                    <span class="block font-semibold text-gray-900">Langsung aktifkan batch</span>
                    <span class="block text-sm text-gray-600">Jika waktu mulai dikosongkan, pengeringan dihitung mulai sekarang.</span>
                </span>
            </label>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                        class="rounded-lg border border-gray-400 px-4 py-2 font-medium text-gray-800 hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-lg bg-eg-dark px-5 py-2 font-medium text-white hover:bg-eg-deep">
                    Simpan
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Modal: konfirmasi nonaktifkan --}}
    <x-modal name="nonaktif-batch" maxWidth="md" focusable>
        <form method="POST" x-bind:action="target.statusUrl" class="p-6">
            @csrf
            @method('PATCH')

            <h2 class="text-xl font-bold text-eg-dark">Nonaktifkan batch?</h2>
            <p class="mt-3 text-gray-800">
                Batch <strong x-text="target.nama"></strong> akan ditandai <strong>Non Aktif</strong>.
                Data waktu mulai, bobot, dan progres tetap tersimpan. Batch bisa diaktifkan lagi kapan saja.
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                        class="rounded-lg border border-gray-400 px-4 py-2 font-medium text-gray-800 hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-lg bg-gray-800 px-5 py-2 font-medium text-white hover:bg-gray-900">
                    Ya, nonaktifkan
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Modal: konfirmasi hapus --}}
    <x-modal name="hapus-batch" maxWidth="md" focusable>
        <form method="POST" x-bind:action="target.hapusUrl" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-xl font-bold text-red-800">Hapus batch?</h2>
            <p class="mt-3 text-gray-800">
                Batch <strong x-text="target.nama"></strong> beserta seluruh datanya akan dihapus
                dan <strong>tidak bisa dikembalikan</strong>.
            </p>
            <p x-show="target.aktif" style="display: none"
               class="mt-3 rounded-lg border-l-4 border-amber-600 bg-amber-50 px-3 py-2 text-amber-900" role="alert">
                Perhatian: batch ini masih <strong>Aktif</strong>. Proses pengeringannya akan ikut terhenti.
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                        class="rounded-lg border border-gray-400 px-4 py-2 font-medium text-gray-800 hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-lg bg-red-700 px-5 py-2 font-medium text-white hover:bg-red-800">
                    Ya, hapus
                </button>
            </div>
        </form>
    </x-modal>

</div>

@endsection
