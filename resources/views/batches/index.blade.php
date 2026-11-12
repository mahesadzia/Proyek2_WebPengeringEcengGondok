@extends('layouts.app')

@section('title', 'Batch')
@section('page-title', 'Batch Pengeringan')

@section('content')
    {{-- Data untuk modal "Hapus": diisi saat tombol Hapus di kartu diklik --}}
    <div x-data="{ hapus: { nama: '', url: '' } }"
         x-on:minta-hapus.window="hapus = $event.detail; $dispatch('open-modal', 'hapus-batch')">

        {{-- Tombol tambah --}}
        <div class="flex justify-end">
            <button type="button" x-on:click.prevent="$dispatch('open-modal', 'tambah-batch')"
                    class="rounded-lg bg-ec-moss px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-ec-forest focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest focus-visible:ring-offset-2">
                + Tambah Batch
            </button>
        </div>

        {{-- Daftar batch --}}
        @if ($batches->isNotEmpty())
            <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-2">
                @foreach ($batches as $batch)
                    @php
                        $progres = max(0, min(100, (int) $batch->progres));
                        $mulai = $batch->waktu_mulai
                            ? $batch->waktu_mulai->copy()->timezone('Asia/Jakarta')->format('d/m/Y · H.i') . ' WIB'
                            : '--/--/---- · --.-- WIB';
                    @endphp

                    <article class="flex flex-col rounded-2xl border border-ec-line p-6 shadow-sm {{ $batch->is_active ? 'bg-white' : 'bg-[#FBF7F3]' }}">

                        {{-- Nama & status --}}
                        <header class="flex items-center justify-between gap-3">
                            <h2 class="truncate text-xl font-semibold text-ec-ink">{{ $batch->nama }}</h2>

                            @if ($batch->is_active)
                                <span class="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full bg-ec-sage px-3 py-1 text-sm font-medium text-ec-moss">
                                    <span class="h-1.5 w-1.5 rounded-full bg-ec-leaf" aria-hidden="true"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full bg-ec-rose px-3 py-1 text-sm font-medium text-ec-rosetext">
                                    <span class="h-1.5 w-1.5 rounded-full bg-ec-rosetext" aria-hidden="true"></span>
                                    Non Aktif
                                </span>
                            @endif
                        </header>

                        {{-- Detail --}}
                        <dl class="mt-5 space-y-2.5 text-sm">
                            <div class="flex items-baseline justify-between gap-4">
                                <dt class="text-ec-ink/70">Waktu mulai</dt>
                                <dd class="font-medium text-ec-ink">{{ $mulai }}</dd>
                            </div>
                            <div class="flex items-baseline justify-between gap-4">
                                <dt class="text-ec-ink/70">Bobot awal</dt>
                                <dd class="font-medium text-ec-ink">{{ $batch->bobot_awal_label }}</dd>
                            </div>
                            <div class="flex items-baseline justify-between gap-4">
                                <dt class="text-ec-ink/70">Bobot aktif</dt>
                                <dd class="font-medium text-ec-ink">{{ $batch->bobot_aktif_label }}</dd>
                            </div>
                        </dl>

                        {{-- Progres --}}
                        <div class="mt-6">
                            <div class="flex items-baseline justify-between">
                                <span class="text-sm text-ec-ink/70">Progres pengeringan</span>
                                <span class="text-2xl font-semibold text-ec-ink">{{ $progres }}%</span>
                            </div>
                            <div role="progressbar" aria-label="Progres pengeringan {{ $batch->nama }}"
                                 aria-valuenow="{{ $progres }}" aria-valuemin="0" aria-valuemax="100"
                                 class="mt-2 h-2.5 overflow-hidden rounded-full bg-ec-sand">
                                <div class="h-full rounded-full bg-ec-leaf transition-all duration-500" style="width: {{ $progres }}%"></div>
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-ec-line pt-4">
                            <form method="POST" action="{{ route('batches.status', $batch) }}">
                                @csrf
                                @method('PATCH')
                                @if ($batch->is_active)
                                    <button type="submit"
                                            class="rounded-lg border border-ec-line bg-white px-4 py-2 text-sm font-medium text-ec-ink hover:bg-ec-cream focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest">
                                        Nonaktifkan
                                    </button>
                                @else
                                    <button type="submit"
                                            class="rounded-lg bg-ec-moss px-4 py-2 text-sm font-medium text-white hover:bg-ec-forest focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest focus-visible:ring-offset-2">
                                        Aktifkan
                                    </button>
                                @endif
                            </form>

                            <button type="button"
                                    x-on:click="$dispatch('minta-hapus', { nama: @js($batch->nama), url: @js(route('batches.destroy', $batch)) })"
                                    class="rounded-lg border border-ec-line bg-white px-4 py-2 text-sm font-medium text-ec-rosetext hover:bg-ec-rose/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-rosetext">
                                Hapus
                            </button>

                            <a href="{{ route('batches.show', $batch) }}"
                               aria-label="Selengkapnya tentang {{ $batch->nama }}"
                               class="ml-auto text-sm font-medium text-ec-moss hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest">
                                Selengkapnya →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-5 rounded-2xl border-2 border-dashed border-ec-line bg-white px-6 py-16 text-center text-ec-ink/70">
                Belum ada batch. Klik <span class="font-semibold">+ Tambah Batch</span> untuk membuat batch pertama.
            </div>
        @endif

        {{-- Modal tambah batch --}}
        <x-modal name="tambah-batch" :show="$errors->tambahBatch->isNotEmpty()" maxWidth="md" focusable>
            <form method="POST" action="{{ route('batches.store') }}" class="p-6">
                @csrf

                <h2 class="text-xl font-semibold text-ec-ink">Tambah Batch</h2>
                <p class="mt-1 text-sm text-ec-ink/70">Batch baru akan muncul di halaman Beranda dan Batch.</p>

                <div class="mt-5">
                    <label for="nama" class="block text-sm font-medium text-ec-ink">Nama Batch</label>
                    <input id="nama" name="nama" type="text" value="{{ old('nama') }}" maxlength="50"
                           placeholder="Contoh: BCH5" autocomplete="off" required
                           class="mt-1.5 block w-full rounded-lg border-ec-line uppercase shadow-sm focus:border-ec-moss focus:ring-ec-moss">
                    @if ($errors->tambahBatch->has('nama'))
                        <p class="mt-1.5 text-sm text-ec-rosetext" role="alert">{{ $errors->tambahBatch->first('nama') }}</p>
                    @endif
                </div>

                <div class="mt-4">
                    <label for="waktu_mulai" class="block text-sm font-medium text-ec-ink">Waktu Mulai Pengeringan</label>
                    <input id="waktu_mulai" name="waktu_mulai" type="datetime-local" value="{{ old('waktu_mulai') }}"
                           class="mt-1.5 block w-full rounded-lg border-ec-line shadow-sm focus:border-ec-moss focus:ring-ec-moss">
                    <p class="mt-1 text-xs text-ec-ink/60">Dalam WIB. Kosongkan jika belum dimulai.</p>
                    @if ($errors->tambahBatch->has('waktu_mulai'))
                        <p class="mt-1.5 text-sm text-ec-rosetext" role="alert">{{ $errors->tambahBatch->first('waktu_mulai') }}</p>
                    @endif
                </div>

                <label class="mt-4 flex items-center gap-2 text-sm text-ec-ink">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active'))
                           class="rounded border-ec-line text-ec-moss focus:ring-ec-moss">
                    Langsung aktifkan batch ini
                </label>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')"
                            class="rounded-lg border border-ec-line bg-white px-4 py-2 text-sm font-medium text-ec-ink hover:bg-ec-cream focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest">
                        Batal
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-ec-moss px-5 py-2 text-sm font-medium text-white hover:bg-ec-forest focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest focus-visible:ring-offset-2">
                        Simpan
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Modal konfirmasi hapus --}}
        <x-modal name="hapus-batch" maxWidth="md" focusable>
            <form method="POST" x-bind:action="hapus.url" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-xl font-semibold text-ec-ink">Hapus batch?</h2>
                <p class="mt-2 text-sm leading-relaxed text-ec-ink/80">
                    Batch <strong x-text="hapus.nama"></strong> akan dihapus permanen beserta datanya.
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')"
                            class="rounded-lg border border-ec-line bg-white px-4 py-2 text-sm font-medium text-ec-ink hover:bg-ec-cream focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest">
                        Batal
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-ec-rosetext px-5 py-2 text-sm font-medium text-white hover:bg-red-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-rosetext focus-visible:ring-offset-2">
                        Ya, hapus
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
@endsection
