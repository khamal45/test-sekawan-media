@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-6">Tambah Kendaraan Baru</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kendaraan.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Kendaraan</label>
                <input type="text" name="nama" id="nama"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('nama') }}" required>
            </div>

            <div>
                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kendaraan</label>
                <select name="jenis" id="jenis"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="angkutan orang" {{ old('jenis') == 'angkutan orang' ? 'selected' : '' }}>Angkutan Orang
                    </option>
                    <option value="angkutan barang" {{ old('jenis') == 'angkutan barang' ? 'selected' : '' }}>Angkutan
                        Barang</option>
                </select>
            </div>

            <div>
                <label for="tipe" class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                <select name="tipe" id="tipe"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    required>
                    <option value="" disabled {{ old('tipe') == null ? 'selected' : '' }}>-- Pilih Tipe --</option>
                    <option value="milik" {{ old('tipe') == 'milik' ? 'selected' : '' }}>Milik</option>
                    <option value="sewaan" {{ old('tipe') == 'sewaan' ? 'selected' : '' }}>Sewaan</option>
                </select>
            </div>

            <div>
                <label for="no_polisi" class="block text-sm font-medium text-gray-700 mb-1">Nomor Polisi</label>
                <input type="text" name="no_polisi" id="no_polisi"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('no_polisi') }}" required>
            </div>

            <div>
                <label for="region" class="block text-sm font-medium text-gray-700 mb-1">Region / Lokasi</label>
                <input type="text" name="region" id="region"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('region') }}" required>
            </div>

            <div>
                <label for="konsumsi_bbm" class="block text-sm font-medium text-gray-700 mb-1">Konsumsi BBM
                    (liter/km)</label>
                <input type="number" step="0.01" name="konsumsi_bbm" id="konsumsi_bbm"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('konsumsi_bbm') }}" required>
            </div>

            <div>
                <label for="jadwal_service_berikutnya" class="block text-sm font-medium text-gray-700 mb-1">Jadwal Service
                    Berikutnya</label>
                <input type="date" name="jadwal_service_berikutnya" id="jadwal_service_berikutnya"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('jadwal_service_berikutnya') }}" required>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2 rounded shadow">
                    Simpan
                </button>
                <a href="{{ route('kendaraan.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium px-5 py-2 rounded shadow">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
