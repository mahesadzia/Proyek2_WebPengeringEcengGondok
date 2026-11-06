@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')

@section('content')
    {{-- Tombol Ubah --}}
    <div class="mt-4 flex justify-end">
        <button type="button" data-open-modal="edit-modal"
                class="flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#9FDB8E] to-eg-moss px-6 py-3 text-lg text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark focus-visible:ring-offset-2">
            <x-icon name="edit" class="h-6 w-6" />
            Ubah
        </button>
    </div>

    {{-- Kartu profil --}}
    <section aria-label="Profil pengguna"
             class="mt-4 rounded-2xl border-[3px] border-eg-dark bg-white px-6 py-12 sm:px-[74px]">
        <div class="flex flex-col items-center gap-8 sm:flex-row sm:items-center">

            {{-- Avatar inisial --}}
            <div aria-hidden="true"
                 class="flex h-[124px] w-[124px] shrink-0 items-center justify-center rounded-xl border-[3px] border-eg-dark bg-gradient-to-br from-eg-mint to-eg-moss text-[80px] font-bold leading-none text-white">
                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
            </div>

            <dl class="w-full min-w-0 flex-1 space-y-1">
                <div>
                    <dt class="text-lg leading-tight">Nama Pengguna</dt>
                    <dd class="truncate border-b border-gray-900 pb-1 text-3xl font-bold italic tracking-tight">
                        {{ $user->name }}
                    </dd>
                </div>
                <div>
                    <dt class="text-lg leading-tight">Password</dt>
                    {{-- Kata sandi disimpan ter-hash, jadi tidak bisa ditampilkan. Tampilkan titik-titik. --}}
                    <dd class="border-b border-gray-900 pb-1 text-3xl font-bold italic tracking-widest"
                        aria-label="Kata sandi disembunyikan">
                        ••••••••
                    </dd>
                </div>
            </dl>
        </div>
    </section>

    {{-- Modal ubah data --}}
    <dialog id="edit-modal" aria-labelledby="edit-modal-title"
            class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border-[3px] border-eg-dark bg-white p-0 text-eg-dark backdrop:bg-black/40"
            @if ($errors->any()) data-auto-open @endif>

        <form method="POST" action="{{ route('settings.update') }}" class="space-y-5 p-6 sm:p-8" novalidate>
            @csrf
            @method('PUT')

            <h2 id="edit-modal-title" class="text-2xl font-bold tracking-tight">Ubah Profil</h2>

            <div>
                <label for="name" class="mb-1 block text-sm font-medium">Nama Pengguna</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name"
                       class="w-full rounded-lg border-2 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-eg-moss {{ $errors->has('name') ? 'border-eg-clay' : 'border-eg-dark/30' }}">
                @error('name')
                    <p role="alert" class="mt-1 text-sm text-eg-rust">{{ $message }}</p>
                @enderror
            </div>

            <fieldset class="space-y-5 rounded-lg border border-eg-dark/20 p-4">
                <legend class="px-2 text-sm">Ganti kata sandi (opsional)</legend>

                <div>
                    <label for="current_password" class="mb-1 block text-sm font-medium">Kata sandi saat ini</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                           class="w-full rounded-lg border-2 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-eg-moss {{ $errors->has('current_password') ? 'border-eg-clay' : 'border-eg-dark/30' }}">
                    @error('current_password')
                        <p role="alert" class="mt-1 text-sm text-eg-rust">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium">Kata sandi baru</label>
                    <input id="password" name="password" type="password" autocomplete="new-password"
                           class="w-full rounded-lg border-2 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-eg-moss {{ $errors->has('password') ? 'border-eg-clay' : 'border-eg-dark/30' }}">
                    @error('password')
                        <p role="alert" class="mt-1 text-sm text-eg-rust">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1 block text-sm font-medium">Ulangi kata sandi baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                           class="w-full rounded-lg border-2 border-eg-dark/30 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-eg-moss">
                </div>

                <p class="text-xs text-eg-dark/70">Kosongkan bagian ini jika tidak ingin mengganti kata sandi.</p>
            </fieldset>

            <div class="flex justify-end gap-3 pt-1">
                <button type="button" data-close-modal
                        class="rounded-lg border-2 border-eg-dark/40 px-5 py-2.5 hover:bg-eg-lime/40 focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-[#9FDB8E] to-eg-moss px-6 py-2.5 font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark focus-visible:ring-offset-2">
                    Simpan
                </button>
            </div>
        </form>
    </dialog>
@endsection

@push('scripts')
<script>
    (() => {
        const modal = document.getElementById('edit-modal');

        document.querySelectorAll('[data-open-modal]').forEach(btn =>
            btn.addEventListener('click', () => modal.showModal()));

        modal.querySelectorAll('[data-close-modal]').forEach(btn =>
            btn.addEventListener('click', () => modal.close()));

        // Klik di area gelap (backdrop) menutup modal.
        modal.addEventListener('click', (e) => { if (e.target === modal) modal.close(); });

        // Buka otomatis jika ada error validasi, agar pesan error terlihat.
        if (modal.hasAttribute('data-auto-open')) modal.showModal();
    })();
</script>
@endpush