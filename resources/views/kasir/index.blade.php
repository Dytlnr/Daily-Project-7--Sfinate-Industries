@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-white">🛒 Transaksi Kasir BARANG</h2>


    {{-- Form Tambah Barang --}}
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-6">
        <form action="{{ route('kasir.tambah') }}" method="POST" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf

            <div>
                <label for="barang_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Barang</label>
                <select name="barang_id" id="barang_id"
                        class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        required>
                    <option value="" disabled selected>-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}">
                            {{ $barang->lokasi }} || {{ $barang->nama_barang }} || {{ $barang->warna }} - Rp{{ number_format($barang->harga_satuan) }} || ({{ $barang->stok }} {{ $barang->satuan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" min="1"
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                       required>
            </div>

            <div>
                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                <input type="text" name="tanggal_selesai" id="tanggal_selesai"
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                       placeholder="dd/mm/yyyy" required>
            </div>

            <div>
                <label for="kd_gramasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Gramasi</label>
                <select name="kd_gramasi" id="kd_gramasi" class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                    <option value="" disabled selected>-- Pilih Gramasi --</option>
                    @foreach ($gramasi as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="kd_tinta" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Tinta</label>
                <select name="kd_tinta" id="kd_tinta" class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                    <option value="" disabled selected>-- Pilih Tinta --</option>
                    @foreach ($tinta as $item)
                    <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="kd_size_dewasa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ukuran Dewasa</label>
                <select name="kd_size_dewasa" id="kd_size_dewasa" class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="" disabled selected>-- Pilih Ukuran Dewasa --</option>
                    @foreach ($ukuranDewasa as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="kd_size_anak" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ukuran Anak</label>
                <select name="kd_size_anak" id="kd_size_anak" class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="" disabled selected>-- Pilih Ukuran Anak --</option>
                    @foreach ($ukuranAnak as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="dp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">DP (Uang Muka)</label>
                <input type="number" name="dp" id="dp" min="0"
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label for="diskon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diskon (Rp)</label>
                <input type="number" name="diskon" id="diskon" min="0"
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label for="total_harga" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Harga</label>
                <input type="hidden" name="total_harga_raw" id="total_harga_raw" value="0">
                <input type="text" id="total_harga" readonly
                       class="w-full mt-1 rounded-md border-gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                       value="Rp0">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Warna</label>
                <button type="button" onclick="openModalWarna()" class="mt-2 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    Pilih Warna
                </button>
                <input type="hidden" name="warna" id="selectedWarna">
                <div id="warnaLabel" class="text-sm mt-1 text-gray-500 dark:text-gray-300"></div>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-green-600 text-white rounded-md py-2 hover:bg-green-700">
                    Tambah ke Keranjang <b>BARANG</b>
                </button>
            </div>

        </form>
    </div>

    <h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-white">🛒 Transaksi Kasir JASA SABLON</h2>

    {{-- Form Tambah Jasa Sablon --}}
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-6">
        <form action="{{ route('kasir.tambahJasaSablon') }}" method="POST" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf

            <div>
                <label for="jenis_jasa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Jasa</label>
                <input type="text" name="jenis_jasa" id="jenis_jasa"
                    class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="Contoh: Sablon Kaos, Sablon Hoodie" required>
            </div>

            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" min="1"
                    class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    required>
            </div>

            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Satuan Jasa (Rp)</label>
                <input type="number" name="harga" id="harga" min="0"
                    class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    required>
            </div>

            <div>
                <label for="tanggal_selesai_jasa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                <input type="text" name="tanggal_selesai_jasa" id="tanggal_selesai_jasa"
                    class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="dd/mm/yyyy" required>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-purple-600 text-white rounded-md py-2 hover:bg-purple-700">
                    Tambah ke Keranjang <b>JASA</b>
                </button>
            </div>
        </form>
    </div>


    {{-- Tabel Keranjang --}}
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
        <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-white">🧾 Keranjang</h4>

        @if(count($keranjang))
        {{-- Form Simpan Transaksi --}}
        <form action="{{ route('kasir.simpan') }}" method="POST">
            @csrf

            {{-- Dropdown Member --}}
            <div class="mb-4">
                <label for="member_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Member (Opsional)</label>
                <select name="member_id" id="member_id"
                        class="select2-member w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="">-- Bukan Member --</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}" data-nama="{{ $member->nama }}">{{ $member->nama }} - {{ $member->telepon }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Pelanggan --}}
            <div class="mb-4">
                <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                    class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan nama pelanggan" required>
            </div>


            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300 mb-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Barang</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Harga Satuan</th>
                        <th class="px-4 py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($keranjang as $index => $item)
                        @php $total += $item['subtotal']; @endphp
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-4 py-2 align-top">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 align-top">{{ $item['nama'] }}</td>
                            <td class="px-4 py-2 align-top">{{ $item['jumlah'] }}</td>
                            <td class="px-4 py-2 align-top">Rp{{ number_format($item['harga']) }}</td>
                            @php
                                $subtotalBersih = $item['harga'] * $item['jumlah'];
                            @endphp
                            <td class="px-4 py-2 align-top">Rp{{ number_format($subtotalBersih) }}</td>
                        <tr class="bg-gray-50 dark:bg-gray-900 text-xs text-gray-600 dark:text-gray-300">
                            <td colspan="5" class="px-4 pb-2 pt-0">
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @if(!empty($item['tinta']))
                                        <div><strong>Tinta:</strong> {{ $item['tinta'] }} (Rp{{ number_format($item['tinta_harga']) }})</div>
                                    @endif
                                    @if(!empty($item['warna']))
                                        <div><strong>Warna:</strong> {{ implode(', ', $item['warna']) }} (Rp{{ number_format($item['warna_harga']) }})</div>
                                    @endif
                                    @if(!empty($item['gramasi']))
                                        <div><strong>Gramasi:</strong> {{ $item['gramasi'] }}</div>
                                    @endif
                                    @if(!empty($item['size_dewasa']))
                                        <div><strong>Ukuran Dewasa:</strong> {{ $item['size_dewasa'] }}</div>
                                    @endif
                                    @if(!empty($item['size_anak']))
                                        <div><strong>Ukuran Anak:</strong> {{ $item['size_anak'] }}</div>
                                    @endif
                                    @if(!empty($item['diskon']))
                                        <div><strong>Diskon:</strong> Rp{{ number_format($item['diskon']) }}</div>
                                    @endif
                                    {{-- @if(!empty($item['dp']))
                                        <div><strong>DP:</strong> Rp{{ number_format($item['dp']) }}</div>
                                    @endif --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    @php
                        $total = 0;
                        $totalDP = 0;
                        $totalDiskon = 0;

                        foreach ($keranjang as $item) {
                            $hargaBarang = $item['harga'] ?? 0;
                            $hargaWarna = $item['warna_harga'] ?? 0;
                            $jumlah = $item['jumlah'] ?? 0;

                            $subtotal = ($hargaBarang + $hargaWarna) * $jumlah;
                            $total += $subtotal;

                            $totalDP += $item['dp'] ?? 0;
                            $totalDiskon += $item['diskon'] ?? 0;
                        }

                        $sisaBayar = $total - $totalDP - $totalDiskon;
                    @endphp

                    <tr class="bg-gray-100 dark:bg-gray-700 font-semibold">
                        <td colspan="4" class="px-4 py-2 text-right">Total</td>
                        <td class="px-4 py-2 text-red-600">Rp{{ number_format($total) }}</td>
                    </tr>

                    <tr class="bg-gray-100 dark:bg-gray-700 font-semibold">
                        <td colspan="4" class="px-4 py-2 text-right">Total Diskon</td>
                        <td class="px-4 py-2 text-green-600">Rp{{ number_format($totalDiskon) }}</td>
                    </tr>

                    <tr class="bg-gray-100 dark:bg-gray-700 font-semibold">
                        <td colspan="4" class="px-4 py-2 text-right">Total DP</td>
                        <td class="px-4 py-2 text-blue-600">Rp{{ number_format($totalDP) }}</td>
                    </tr>

                    <tr class="bg-gray-100 dark:bg-gray-700 font-semibold">
                        <td colspan="4" class="px-4 py-2 text-right">Sisa Bayar</td>
                        <td class="px-4 py-2 text-orange-600">
                            Rp{{ number_format($sisaBayar > 0 ? $sisaBayar : 0) }}
                        </td>
                    </tr>
                </tfoot>

            </table>

            <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-2">
                {{-- Tombol Simpan Transaksi (Kiri) --}}
                <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan Transaksi
                </button>

                {{-- Tombol Reset Keranjang (Kanan) --}}
            </form> {{-- <-- Ini penutup form kasir.simpan, letaknya harus di sini --}}

            <form action="{{ route('kasir.reset') }}" method="POST" onsubmit="return confirm('Kosongkan keranjang?')" class="w-full md:w-auto">
                @csrf
                <button type="submit" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Reset Keranjang
                </button>
            </form>
        @else
            <p class="text-gray-600 dark:text-gray-300">Keranjang masih kosong.</p>
        @endif
    </div>

    {{-- Tabel Keranjang Jasa Sablon --}}
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mt-6">
        <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-white">🧾 Keranjang Jasa Sablon</h4>

        @php $keranjangJasa = Session::get('keranjang_jasa', []); @endphp

        @if(count($keranjangJasa))
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300 mb-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Jenis Jasa</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Harga</th>
                        <th class="px-4 py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalJasa = 0; @endphp
                    @foreach($keranjangJasa as $index => $item)
                        @php $totalJasa += $item['subtotal']; @endphp
                        <tr>
                            <td class="px-4 py-2">{{ $index+1 }}</td>
                            <td class="px-4 py-2">{{ $item['jenis_jasa'] }}</td>
                            <td class="px-4 py-2">{{ $item['jumlah'] }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($item['harga']) }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($item['subtotal']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-100 dark:bg-gray-700 font-semibold">
                        <td colspan="4" class="px-4 py-2 text-right">Total</td>
                        <td class="px-4 py-2 text-red-600">Rp{{ number_format($totalJasa) }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Form Simpan -->
            <form action="{{ route('kasir.simpanJasaSablon') }}" method="POST" class="mb-2">
                @csrf

                {{-- Input nama pelanggan --}}
                <div class="mb-4">
                    <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Pelanggan
                    </label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                            value="{{ old('nama_pelanggan') }}"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm
                                    focus:border-purple-500 focus:ring focus:ring-purple-200
                                    dark:bg-gray-700 dark:text-white" required>
                </div>
            <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-2">
                <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan Transaksi Jasa
                </button>
            </form>

            <!-- Form Reset -->
            <form action="{{ route('kasir.resetKeranjangJasa') }}" method="POST">
                @csrf
                <button type="submit" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Reset Keranjang Jasa
                </button>
            </form>
        @else
            <p class="text-gray-600 dark:text-gray-300">Keranjang jasa masih kosong.</p>
        @endif
    </div>
</div>

<div id="warnaModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Pilih Jenis Warna</h3>
        <div class="space-y-2 max-h-60 overflow-y-auto">
            @foreach($jenisWarna as $warna)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="warna-checkbox" value="{{ $warna->id }}" data-nama="{{ $warna->nama }}" data-harga="{{ $warna->harga }}">
                    <span class="text-sm text-gray-700 dark:text-white">{{ $warna->nama }} (Rp{{ number_format($warna->harga) }})</span>
                </label>
            @endforeach
        </div>
        <div class="flex justify-end mt-4">
            <button type="button" onclick="closeModalWarna()" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
            <button type="button" onclick="simpanWarna()" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    const barangSelect = document.getElementById('barang_id');
    const jumlahInput = document.getElementById('jumlah');
    const totalHargaInput = document.getElementById('total_harga');
    const tintaSelect = document.getElementById('kd_tinta');

    // Data dari Blade ke JS
    const barangHarga = {
        @foreach ($barangs as $barang)
            "{{ $barang->id }}": {{ $barang->harga_satuan }},
        @endforeach
    };

    const tintaHarga = {
        @foreach ($tinta as $item)
            "{{ $item->id }}": {{ $item->harga }},
        @endforeach
    };

    const warnaHarga = {
        @foreach ($jenisWarna as $item)
            "{{ $item->id }}": {{ $item->harga }},
        @endforeach
    };

    function updateTotalHarga() {
        const barangId = barangSelect.value;
        const jumlah = parseInt(jumlahInput.value) || 0;
        const hargaBarang = barangHarga[barangId] || 0;
        const hargaTinta = tintaHarga[tintaSelect?.value] || 0;

        const warnaTerpilih = document.getElementById('selectedWarna').value.split(',').filter(id => id !== '');
        let totalWarna = 0;

        warnaTerpilih.forEach(id => {
            totalWarna += (warnaHarga[id] || 0) * jumlah; // dikali jumlah
        });

        const total = (hargaBarang * jumlah) + hargaTinta + totalWarna;

        totalHargaInput.value = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(total);

        const rawInput = document.getElementById('total_harga_raw');
        if (rawInput) rawInput.value = total;
    }

    // Event listener
    barangSelect.addEventListener('change', updateTotalHarga);
    jumlahInput.addEventListener('input', updateTotalHarga);
    tintaSelect.addEventListener('change', updateTotalHarga);

    // Flatpickr
    flatpickr("#tanggal_selesai", {
        dateFormat: "d/m/Y",
        defaultDate: new Date(),
    });

    flatpickr("#tanggal_selesai_jasa", {
        dateFormat: "d/m/Y",
        defaultDate: new Date(),
    });

    // Select2 & Member autofill
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi select2
        $('.select2-member').select2({
            placeholder: "-- Pilih Member --",
            allowClear: true,
            width: '100%'
        });

        // Ketika member dipilih, isi otomatis nama pelanggan
        $('#member_id').on('change', function () {
            updateNamaPelanggan();
        });

    });

    document.addEventListener('DOMContentLoaded', function () {
        const memberSelect = document.getElementById('member_id');
        const namaInput = document.getElementById('nama_pelanggan');

        function updateNamaPelanggan() {
            const selectedOption = memberSelect.options[memberSelect.selectedIndex];
            const nama = selectedOption.getAttribute('data-nama');

            if (memberSelect.value !== "") {
                namaInput.value = nama || "";
                namaInput.readOnly = true;
            } else {
                namaInput.value = "";
                namaInput.readOnly = false;
                namaInput.focus();
            }
        }

        memberSelect.addEventListener('change', updateNamaPelanggan);
        updateNamaPelanggan(); // Panggil saat pertama kali halaman load
    });

    // Modal Warna
    function openModalWarna() {
        document.getElementById('warnaModal').classList.remove('hidden');
    }

    function closeModalWarna() {
        document.getElementById('warnaModal').classList.add('hidden');
    }

    function simpanWarna() {
        const checkboxes = document.querySelectorAll('.warna-checkbox:checked');
        const ids = [];
        const labels = [];

        checkboxes.forEach(cb => {
            ids.push(cb.value);
            labels.push(cb.dataset.nama);
        });

        document.getElementById('selectedWarna').value = ids.join(',');
        document.getElementById('warnaLabel').innerText = 'Warna Dipilih: ' + labels.join(', ');
        closeModalWarna();
        updateTotalHarga();
    }
</script>



@endsection