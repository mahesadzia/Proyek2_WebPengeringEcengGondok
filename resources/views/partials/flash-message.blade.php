@php
    $flashes = collect([
        'success' => ['border-ec-leaf bg-ec-sage/70 text-ec-moss', 'Berhasil'],
        'warning' => ['border-ec-amberline bg-ec-amber text-ec-amberink', 'Perhatian'],
        'error'   => ['border-ec-rosetext bg-ec-rose text-ec-rosetext', 'Gagal'],
    ])->filter(fn ($style, $key) => session()->has($key));
@endphp

@foreach ($flashes as $key => [$style, $label])
    <div role="{{ $key === 'error' ? 'alert' : 'status' }}"
         class="mb-5 flex items-start justify-between gap-4 rounded-lg border-l-4 px-4 py-3 text-sm {{ $style }}">
        <p><span class="font-semibold">{{ $label }}:</span> {{ session($key) }}</p>
        <button type="button" onclick="this.parentElement.remove()" class="text-xl leading-none" aria-label="Tutup pesan">&times;</button>
    </div>
@endforeach

@if ($errors->any())
    <div role="alert" class="mb-5 rounded-lg border-l-4 border-ec-rosetext bg-ec-rose px-4 py-3 text-sm text-ec-rosetext">
        <p class="font-semibold">Periksa kembali isian Anda:</p>
        <ul class="mt-1 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
