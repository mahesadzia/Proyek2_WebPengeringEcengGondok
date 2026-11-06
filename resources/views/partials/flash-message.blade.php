@php
    $flashes = collect([
        'success' => ['border-green-700 bg-green-50 text-green-900', 'Berhasil'],
        'warning' => ['border-amber-600 bg-amber-50 text-amber-900', 'Perhatian'],
        'error'   => ['border-red-700 bg-red-50 text-red-900', 'Gagal'],
    ])->filter(fn ($style, $key) => session()->has($key));
@endphp

@foreach ($flashes as $key => [$style, $label])
    <div role="{{ $key === 'error' ? 'alert' : 'status' }}"
         class="mb-5 flex items-start justify-between gap-4 rounded-lg border-l-4 px-4 py-3 {{ $style }}">
        <p><span class="font-semibold">{{ $label }}:</span> {{ session($key) }}</p>
        <button type="button" onclick="this.parentElement.remove()"
                class="rounded px-1 text-2xl leading-none focus:outline-none focus-visible:ring-2 focus-visible:ring-current" aria-label="Tutup pesan">&times;</button>
    </div>
@endforeach

@if ($errors->any())
    <div role="alert" class="mb-5 rounded-lg border-l-4 border-red-700 bg-red-50 px-4 py-3 text-red-900">
        <p class="font-semibold">Periksa kembali isian Anda:</p>
        <ul class="mt-1 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
