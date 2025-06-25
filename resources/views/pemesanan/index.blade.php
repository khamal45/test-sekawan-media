@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-xl sm:text-2xl font-semibold mb-4">Daftar Pemesanan Kendaraan</h1>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-300 relative">
                {{ session('success') }}
                <button type="button" onclick="this.parentElement.remove()"
                    class="absolute right-3 top-3 text-green-600 hover:text-green-800 font-bold text-lg leading-none">
                    &times;
                </button>
            </div>
        @endif

        <div class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-3">
            <a href="{{ route('pemesanan.create') }}"
                class="w-full sm:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded shadow">
                Buat Pemesanan Baru
            </a>


            <form action="{{ route('export.pemesanan') }}" method="GET" class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <select name="bulan" class="border-gray-300 rounded px-7 py-1">
                    <option value="">Semua Bulan</option>
                    @foreach (range(1, 12) as $b)
                        <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                <select name="tahun" class="border-gray-300 rounded px-7 py-1">
                    <option value="">Semua Tahun</option>
                    @foreach (range(now()->year, now()->year - 5) as $y)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                            {{ $y }}</option>
                    @endforeach
                </select>

                <button type="submit"
                    class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded shadow">
                    Export ke Excel
                </button>
            </form>
        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th scope="col" class="px-4 py-3">User</th>
                        <th scope="col" class="px-4 py-3">Kendaraan</th>
                        <th scope="col" class="px-4 py-3">Driver</th>
                        <th scope="col" class="px-4 py-3">Tanggal Mulai</th>
                        <th scope="col" class="px-4 py-3">Tanggal Selesai</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pemesanan as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->user->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->kendaraan->nama }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->driver }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $badgeColor = match ($item->status) {
                                        'disetujui' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded {{ $badgeColor }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <a href="{{ route('pemesanan.edit', $item->id) }}"
                                        class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 text-xs font-semibold rounded text-center">
                                        Edit
                                    </a>
                                    <form action="{{ route('pemesanan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-3 py-1 text-xs font-semibold rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                Belum ada pemesanan kendaraan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
