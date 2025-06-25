@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-semibold mb-6">Daftar Kendaraan</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('kendaraan.create') }}"
            class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + Tambah Kendaraan
        </a>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Jenis</th>
                        <th class="px-4 py-2 border">Tipe</th>
                        <th class="px-4 py-2 border">No Polisi</th>
                        <th class="px-4 py-2 border">Region</th>
                        <th class="px-4 py-2 border">BBM (L/km)</th>
                        <th class="px-4 py-2 border">Service Berikutnya</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kendaraans as $kendaraan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $kendaraan->nama }}</td>
                            <td class="px-4 py-2 border">{{ ucfirst($kendaraan->jenis) }}</td>
                            <td class="px-4 py-2 border">{{ ucfirst($kendaraan->tipe) }}</td>
                            <td class="px-4 py-2 border">{{ $kendaraan->no_polisi }}</td>
                            <td class="px-4 py-2 border">{{ $kendaraan->region }}</td>
                            <td class="px-4 py-2 border">{{ $kendaraan->konsumsi_bbm }}</td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($kendaraan->jadwal_service_berikutnya)->format('d M Y') }}</td>
                            <td class="px-4 py-2 border whitespace-nowrap">
                                <a href="{{ route('kendaraan.edit', $kendaraan) }}"
                                    class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs mr-1">
                                    Edit
                                </a>

                                <form action="{{ route('kendaraan.destroy', $kendaraan) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500 border">Belum ada data kendaraan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
