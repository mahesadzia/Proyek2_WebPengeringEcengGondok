@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')

@section('content')
    @php($user = auth()->user())

    <section class="rounded-2xl border-2 border-eg-dark bg-white p-6 shadow-sm sm:p-9"
             x-data="{ edit: {{ $errors->any() ? 'true' : 'false' }}, lihat: false }">

        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-eg-dark">Profil Pengguna</h2>
                <p class="mt-1 text-sm text-gray-600">Informasi akun yang terdaftar pada sistem.</p>
            </div>

            <button type="button" x-show="!edit" x-on:click="edit = true; $nextTick(() => $refs.nama.focus())"
                    class="rounded-lg bg-eg-dark px-5 py-2.5 font-medium text-white hover:bg-eg-deep focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark focus-visible:ring-offset-2">
                Ubah
            </button>
        </div>

        <div class="mt-8 flex flex-col items-center gap-8 sm:flex-row sm:items-start sm:gap-12">


            <form method="POST" action="{{ route('pengaturan.update') }}" class="w-full min-w-0 flex-1">
                @csrf
                @method('PUT')

                <div>
                    <label for="email" class="block font-medium text-gray-800">Email</label>
                    <input id="email" type="email" value="{{ $user->email }}" readonly
                           class="mt-1 block w-full border-0 border-b border-gray-400 bg-transparent px-1 py-2 text-lg font-semibold italic text-gray-700 focus:ring-0">
                </div>

                <div class="mt-5">
                    <label for="name" class="block font-medium text-gray-800">Nama Pengguna</label>
                    <input id="name" name="name" type="text" x-ref="nama" required
                           value="{{ old('name', $user->name) }}"
                           x-bind:readonly="!edit" x-bind:class="edit ? '' : 'italic'"
                           class="mt-1 block w-full border-0 border-b border-gray-400 bg-transparent px-1 py-2 text-lg font-semibold text-eg-dark focus:border-eg-moss focus:ring-0">
                </div>

                <div class="mt-5">
                    <label for="password" class="block font-medium text-gray-800">Password Baru</label>
                    <div class="relative">
                        <input id="password" name="password" autocomplete="new-password"
                               x-bind:type="lihat ? 'text' : 'password'"
                               x-bind:readonly="!edit"
                               x-bind:placeholder="edit ? 'Masukkan password baru' : 'Kosongkan jika tidak diubah'"
                               placeholder="Kosongkan jika tidak diubah"
                               class="mt-1 block w-full border-0 border-b border-gray-500 bg-transparent px-1 py-2 pr-24 text-lg font-semibold text-eg-dark focus:border-eg-moss focus:ring-0">
                        <button type="button" x-show="edit" style="display: none" x-on:click="lihat = !lihat"
                                class="absolute right-1 top-1/2 -translate-y-1/2 text-sm font-medium text-eg-dark hover:underline"
                                x-text="lihat ? 'Sembunyikan' : 'Lihat'">Lihat</button>
                    </div>
                    <p x-show="edit" style="display: none" class="mt-1 text-sm text-gray-600">
                        Minimal 8 karakter. Kosongkan jika password tidak ingin diganti.
                    </p>
                </div>

                <div x-show="edit" style="display: none" class="mt-7 flex justify-end gap-3">
                    <a href="{{ route('pengaturan.index') }}"
                       class="rounded-lg border border-gray-400 px-5 py-2.5 font-medium text-gray-800 hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit"
                            class="rounded-lg bg-eg-dark px-5 py-2.5 font-medium text-white hover:bg-eg-deep focus:outline-none focus-visible:ring-2 focus-visible:ring-eg-dark focus-visible:ring-offset-2">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-8 rounded-lg border border-green-700/20 bg-green-50 px-4 py-3 text-green-900">
            <strong>Informasi:</strong> untuk mengubah data akun, klik tombol <b>Ubah</b>.
            Pastikan data yang dimasukkan sudah benar sebelum disimpan.
        </p>
    </section>
@endsection