@php
    $flashes = collect([
        'success' => ['border-eg-moss bg-eg-lime/50 text-eg-dark', 'Berhasil'],
        'warning' => ['border-amber-500 bg-amber-50 text-amber-800', 'Perhatian'],
        'error'   => ['border-eg-clay bg-eg-blush/40 text-eg-rust', 'Gagal'],
    ])->filter(fn ($style, $key) => session()->has($key));
@endphp

@foreach ($flashes as $key => [$style, $label])
    <div role="{{ $key === 'error' ? 'alert' : 'status' }}"
         class="mb-5 flex items-start justify-between gap-4 rounded-lg border-l-4 px-4 py-3 {{ $style }}">
        <p><span class="font-semibold">{{ $label }}:</span> {{ session($key) }}</p>
        <button type="button" onclick="this.parentElement.remove()" class="text-xl leading-none" aria-label="Tutup pesan">&times;</button>
    </div>
@endforeach

@if ($errors->any())
    <div role="alert" class="mb-5 rounded-lg border-l-4 border-eg-clay bg-eg-blush/40 px-4 py-3 text-eg-rust">
        <p class="font-semibold">Periksa kembali isian Anda:</p>
        <ul class="mt-1 list-inside list-disc text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif