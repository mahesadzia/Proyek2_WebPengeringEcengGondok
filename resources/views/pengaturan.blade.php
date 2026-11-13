@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')

@section('content')
    @php
        $user = auth()->user();
        $inisial = strtoupper(mb_substr(trim($user->name ?? ''), 0, 1)) ?: 'A';
        $bergabung = $user->created_at?->copy()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y');
        $diperbarui = $user->updated_at?->copy()->locale('id')->diffForHumans();

        $input = 'mt-1.5 block w-full rounded-lg border bg-white px-3.5 py-2.5 text-ec-ink shadow-sm placeholder:text-ec-ink/40 focus:border-ec-moss focus:outline-none focus:ring-2 focus:ring-ec-moss/30';
    @endphp

    <div class="grid items-start gap-5 lg:grid-cols-[19rem_minmax(0,1fr)]">

        {{-- Ringkasan akun --}}
        <aside class="space-y-4">
            <section class="rounded-2xl border border-ec-line bg-white p-6 text-center shadow-sm" aria-label="Ringkasan akun">
                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-ec-forest text-4xl font-semibold text-white"
                     aria-hidden="true">{{ $inisial }}</div>

                <h2 class="mt-4 break-words text-xl font-semibold text-ec-ink">{{ $user->name }}</h2>
                <p class="mt-0.5 break-all text-sm text-ec-ink/70">{{ $user->email }}</p>

                <dl class="mt-5 space-y-2.5 border-t border-ec-line pt-4 text-left text-sm">
                    <div class="flex justify-between gap-3">
                        <dt class="text-ec-ink/70">Bergabung</dt>
                        <dd class="font-medium text-ec-ink">{{ $bergabung ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-ec-ink/70">Diperbarui</dt>
                        <dd class="font-medium text-ec-ink">{{ $diperbarui ?? '-' }}</dd>
                    </div>
                </dl>
            </section>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl border border-ec-line bg-white px-4 py-3 text-sm font-medium text-ec-rosetext shadow-sm hover:bg-ec-rose/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-rosetext">
                    <x-icon name="logout" class="h-5 w-5" />
                    Keluar dari akun
                </button>
            </form>
        </aside>

        {{-- Formulir --}}
        <form method="POST" action="{{ route('pengaturan.update') }}"
              x-data="{
                  awal: @js($user->name),
                  awalEmail: @js($user->email),
                  nama: @js(old('name', $user->name)),
                  email: @js(old('email', $user->email)),
                  pwSekarang: '',
                  pw: '',
                  lihat: false,
                  get emailBerubah() { return this.email.trim().toLowerCase() !== this.awalEmail.toLowerCase() },
                  get berubah() { return this.nama.trim() !== this.awal || this.emailBerubah || this.pw.length > 0 },
                  reset() { this.nama = this.awal; this.email = this.awalEmail; this.pwSekarang = ''; this.pw = ''; this.lihat = false },
              }"
              class="overflow-hidden rounded-2xl border border-ec-line bg-white shadow-sm">
            @csrf
            @method('PUT')

            {{-- Profil --}}
            <div class="p-6 sm:p-8">
                <h2 class="text-xl font-semibold text-ec-ink">Profil</h2>
                <p class="mt-1 text-sm text-ec-ink/70">Informasi akun yang terdaftar pada sistem.</p>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-ec-ink">Nama pengguna</label>
                        <input id="name" name="name" type="text" x-model="nama" required maxlength="255"
                               autocomplete="name"
                               @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
                               class="{{ $input }} @error('name') border-ec-rosetext @else border-ec-line @enderror">
                        @error('name')
                            <p id="name-error" class="mt-1.5 text-sm text-ec-rosetext" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-ec-ink">Email untuk masuk</label>
                        <input id="email" name="email" type="email" x-model="email" required maxlength="255"
                               autocomplete="email" aria-describedby="email-bantuan"
                               @error('email') aria-invalid="true" @enderror
                               class="{{ $input }} @error('email') border-ec-rosetext @else border-ec-line @enderror">
                        @error('email')
                            <p class="mt-1.5 text-sm text-ec-rosetext" role="alert">{{ $message }}</p>
                        @enderror
                        <p id="email-bantuan" class="mt-1.5 text-xs text-ec-ink/60">Email ini dipakai untuk masuk ke sistem.</p>
                    </div>

                    {{-- Muncul hanya saat email diubah --}}
                    <div class="sm:col-span-2" x-show="emailBerubah" style="display: none">
                        <div class="rounded-xl border border-ec-amberline bg-ec-amber p-4 sm:max-w-md">
                            <label for="password_sekarang" class="block text-sm font-medium text-ec-amberink">Password saat ini</label>
                            <input id="password_sekarang" name="password_sekarang" type="password" x-model="pwSekarang"
                                   x-bind:required="emailBerubah" autocomplete="current-password"
                                   placeholder="Konfirmasi dengan password Anda"
                                   @error('password_sekarang') aria-invalid="true" @enderror
                                   class="{{ $input }} @error('password_sekarang') border-ec-rosetext @else border-ec-line @enderror">
                            @error('password_sekarang')
                                <p class="mt-1.5 text-sm text-ec-rosetext" role="alert">{{ $message }}</p>
                            @enderror
                            <p class="mt-1.5 text-xs text-ec-amberink/80">Diperlukan untuk keamanan saat mengganti email login.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keamanan --}}
            <div class="border-t border-ec-line p-6 sm:p-8">
                <h2 class="text-xl font-semibold text-ec-ink">Keamanan</h2>
                <p class="mt-1 text-sm text-ec-ink/70">Ganti password akun Anda. Kosongkan jika tidak ingin mengubahnya.</p>

                <div class="mt-6 max-w-md">
                    <label for="password" class="block text-sm font-medium text-ec-ink">Password baru</label>
                    <div class="relative">
                        <input id="password" name="password" x-model="pw" x-bind:type="lihat ? 'text' : 'password'"
                               autocomplete="new-password" placeholder="Masukkan password baru"
                               aria-describedby="password-bantuan"
                               @error('password') aria-invalid="true" @enderror
                               class="{{ $input }} pr-24 @error('password') border-ec-rosetext @else border-ec-line @enderror">
                        <button type="button" x-on:click="lihat = !lihat" x-bind:aria-pressed="lihat"
                                class="absolute right-3 top-1/2 mt-0.5 -translate-y-1/2 rounded text-sm font-medium text-ec-moss hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-moss"
                                x-text="lihat ? 'Sembunyikan' : 'Lihat'">Lihat</button>
                    </div>

                    @error('password')
                        <p class="mt-1.5 text-sm text-ec-rosetext" role="alert">{{ $message }}</p>
                    @enderror

                    <p id="password-bantuan" class="mt-2 flex items-center gap-2 text-xs transition-colors"
                       x-bind:class="pw.length >= 8 ? 'text-ec-moss' : 'text-ec-ink/60'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" x-show="pw.length < 8"/>
                            <path d="m5 12.5 4.5 4.5L19 7.5" x-show="pw.length >= 8" style="display: none"/>
                        </svg>
                        Minimal 8 karakter
                    </p>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-ec-line bg-ec-cream/50 px-6 py-4 sm:px-8">
                <p class="text-sm text-ec-ink/70" role="status" x-show="berubah" style="display: none">
                    Ada perubahan yang belum disimpan.
                </p>
                <span x-show="!berubah" class="text-sm text-ec-ink/50">Belum ada perubahan.</span>

                <div class="ml-auto flex gap-3">
                    <button type="button" x-on:click="reset()" x-bind:disabled="!berubah"
                            class="rounded-lg border border-ec-line bg-white px-4 py-2 text-sm font-medium text-ec-ink hover:bg-ec-cream focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:bg-white">
                        Batal
                    </button>
                    <button type="submit" x-bind:disabled="!berubah"
                            class="rounded-lg bg-ec-moss px-5 py-2 text-sm font-medium text-white hover:bg-ec-forest focus:outline-none focus-visible:ring-2 focus-visible:ring-ec-forest focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:bg-ec-moss">
                        Simpan perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
