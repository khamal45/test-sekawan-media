@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-xl font-semibold mb-6">Edit Pemesanan Kendaraan</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded text-red-800">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pemesanan.update', $pemesanan->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="kendaraan_id" class="block text-sm font-medium text-gray-700 mb-1">Kendaraan</label>
                <select name="kendaraan_id" id="kendaraan_id"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400"
                    required>
                    <option value="">-- Pilih Kendaraan --</option>
                    @foreach ($kendaraans as $kendaraan)
                        <option value="{{ $kendaraan->id }}"
                            {{ $kendaraan->id == old('kendaraan_id', $pemesanan->kendaraan_id) ? 'selected' : '' }}>
                            {{ $kendaraan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="driver" class="block text-sm font-medium text-gray-700 mb-1">Nama Driver</label>
                <input type="text" name="driver" id="driver"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('driver', $pemesanan->driver) }}" required>
            </div>

            <div>
                <label for="approver1_id" class="block text-sm font-medium text-gray-700 mb-1">Approver 1</label>
                <select name="approver1_id" id="approver1_id"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400"
                    required>
                    <option value="">-- Pilih Approver 1 --</option>
                    @foreach ($approvers as $approver)
                        <option value="{{ $approver->id }}"
                            {{ $approver->id == old('approver1_id', $pemesanan->approver1_id) ? 'selected' : '' }}>
                            {{ $approver->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="approver2_id" class="block text-sm font-medium text-gray-700 mb-1">Approver 2</label>
                <select name="approver2_id" id="approver2_id"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
                    <option value="">-- Pilih Approver 2 --</option>
                    @foreach ($approvers as $approver)
                        @if ($approver->id != old('approver1_id', $pemesanan->approver1_id))
                            <option value="{{ $approver->id }}"
                                {{ $approver->id == old('approver2_id', $pemesanan->approver2_id) ? 'selected' : '' }}>
                                {{ $approver->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="text" name="tanggal_mulai" id="tanggal_mulai"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($pemesanan->tanggal_mulai)->format('Y-m-d')) }}"
                    required>
            </div>

            <div>
                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="text" name="tanggal_selesai" id="tanggal_selesai"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($pemesanan->tanggal_selesai)->format('Y-m-d')) }}"
                    required>
            </div>

            <div>
                <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
                <textarea name="keperluan" id="keperluan" rows="3"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400"
                    required>{{ old('keperluan', $pemesanan->keperluan) }}</textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 mt-6">
                <button type="submit"
                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm font-medium rounded shadow">
                    Perbarui Pemesanan
                </button>
                <a href="{{ route('pemesanan.index') }}"
                    class="w-full sm:w-auto text-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 text-sm font-medium rounded shadow">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kendaraanSelect = document.getElementById('kendaraan_id');
            const tanggalMulai = flatpickr("#tanggal_mulai", {
                dateFormat: "Y-m-d",
                disable: [],
                defaultDate: "{{ old('tanggal_mulai', \Carbon\Carbon::parse($pemesanan->tanggal_mulai)->format('Y-m-d')) }}",
                onDayCreate: highlightDisabledDates
            });

            const tanggalSelesai = flatpickr("#tanggal_selesai", {
                dateFormat: "Y-m-d",
                disable: [],
                defaultDate: "{{ old('tanggal_selesai', \Carbon\Carbon::parse($pemesanan->tanggal_selesai)->format('Y-m-d')) }}",
                onDayCreate: highlightDisabledDates
            });

            kendaraanSelect.addEventListener('change', function() {
                const kendaraanId = this.value;
                if (!kendaraanId) return;

                fetch(
                        `{{ route('pemesanan.bookedDates') }}?kendaraan_id=${kendaraanId}&except_id={{ $pemesanan->id }}`)
                    .then(res => res.json())
                    .then(data => {
                        tanggalMulai.set('disable', data);
                        tanggalSelesai.set('disable', data);
                        tanggalMulai.redraw();
                        tanggalSelesai.redraw();
                    })
                    .catch(err => console.error('Gagal memuat tanggal yang diblokir:', err));
            });

            function highlightDisabledDates(dObj, dStr, fp, dayElem) {
                const date = dayElem.dateObj.toISOString().slice(0, 10);
                const disabled = fp.config.disable;
                const isDisabled = disabled.some(range =>
                    typeof range === 'object' && range.from && range.to &&
                    date >= range.from && date <= range.to
                );
                if (isDisabled) {
                    dayElem.style.backgroundColor = '#f87171';
                    dayElem.style.color = 'white';
                    dayElem.style.borderRadius = '6px';
                }
            }

            kendaraanSelect.dispatchEvent(new Event('change')); // Inisialisasi
        });
    </script>
@endsection
