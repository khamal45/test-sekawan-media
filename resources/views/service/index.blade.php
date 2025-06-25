@extends('layouts.app')

@push('scripts')
    <script src="https://unpkg.com/alpinejs" defer></script>
@endpush

@section('content')
    <div x-data="jadwalServiceModal()" class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <h2 class="text-2xl font-bold mb-6">Jadwal Service Kendaraan</h2>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No Polisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jadwal Service
                            Berikutnya</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($kendaraans as $index => $kendaraan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kendaraan->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kendaraan->jenis }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $kendaraan->tipe }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kendaraan->no_polisi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($kendaraan->jadwal_service_berikutnya)
                                    {{ \Carbon\Carbon::parse($kendaraan->jadwal_service_berikutnya)->translatedFormat('d F Y') }}
                                @else
                                    <span class="text-gray-400 italic">Belum dijadwalkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button @click="openModal({{ $kendaraan->id }})"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    Update Jadwal Service
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada kendaraan terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div x-show="show" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
                <h2 class="text-lg font-semibold mb-4">Update Jadwal Service</h2>

                <form :action="'/service/jadwal/' + kendaraanId" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="tanggal_service" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Service
                            Terakhir</label>
                        <input type="date" name="tanggal_service" x-model="tanggalService"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function jadwalServiceModal() {
            return {
                show: false,
                kendaraanId: null,
                tanggalService: null,

                openModal(id) {
                    const today = new Date().toISOString().split('T')[0];
                    this.kendaraanId = id;
                    this.tanggalService = today;
                    this.show = true;
                },

                closeModal() {
                    this.show = false;
                    this.kendaraanId = null;
                    this.tanggalService = null;
                }
            };
        }
    </script>
@endsection
