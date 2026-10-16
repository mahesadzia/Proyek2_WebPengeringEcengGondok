@extends('layouts.app')

@section('title', 'Beranda')
@section('page-title', 'Beranda')

@section('content')
    <h2 class="text-3xl font-bold tracking-tight">
        Selamat Datang, {{ auth()->user()->name ?? 'Pengguna' }}!
    </h2>

    <section aria-labelledby="status-batch-title"
             class="mt-9 overflow-hidden rounded-2xl border-[3px] border-eg-dark bg-white">
        <h3 id="status-batch-title" class="px-6 pb-8 pt-9 text-3xl font-bold tracking-tight sm:px-11">
            Status Sistem / Batch
        </h3>

        @if ($batches->isNotEmpty())
            <ul>
                @foreach ($batches as $batch)
                    <x-batch-row :batch="$batch" />
                @endforeach
            </ul>
        @else
            <p class="border-t border-eg-dark/20 px-6 py-10 text-center text-eg-dark/70 sm:px-11">
                Belum ada batch. Tambahkan batch pertama di menu Batch untuk mulai memantau pengeringan.
            </p>
        @endif
    </section>
@endsection