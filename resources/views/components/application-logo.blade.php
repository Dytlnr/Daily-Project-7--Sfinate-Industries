@if (!empty($global_pengaturan->logo))
    <img src="{{ asset('logo/' . $global_pengaturan->logo) }}" alt="Logo" class="mx-auto h-20 mb-4">
@else
    <h2 class="text-2xl font-bold text-center">KONVEKSI</h2>
@endif