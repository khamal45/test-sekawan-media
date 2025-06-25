@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-6">Buat Pemesanan Kendaraan</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pemesanan.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="kendaraan_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kendaraan</label>
                <select name="kendaraan_id" id="kendaraan_id"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    required>
                    <option value="">-- Pilih Kendaraan --</option>
                    @foreach ($kendaraans as $kendaraan)
                        <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                            {{ $kendaraan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="driver" class="block text-sm font-medium text-gray-700 mb-1">Nama Driver</label>
                <input type="text" name="driver" id="driver"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('driver') }}" required>
            </div>

            <div>
                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="text" name="tanggal_mulai" id="tanggal_mulai"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('tanggal_mulai') }}" required readonly>
            </div>

            <div>
                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="text" name="tanggal_selesai" id="tanggal_selesai"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('tanggal_selesai') }}" required readonly>
            </div>

            <div>
                <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
                <textarea name="keperluan" id="keperluan" rows="3"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    required>{{ old('keperluan') }}</textarea>
            </div>

            <div>
                <label for="approver1_id" class="block text-sm font-medium text-gray-700 mb-1">Pihak Penyetuju 1</label>
                <select name="approver1_id" id="approver1_id"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    required>
                    <option value="">-- Pilih Approver 1 --</option>
                    @foreach ($approvers as $approver)
                        <option value="{{ $approver->id }}" {{ old('approver1_id') == $approver->id ? 'selected' : '' }}>
                            {{ $approver->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="approver2_id" class="block text-sm font-medium text-gray-700 mb-1">Pihak Penyetuju 2</label>
                <select name="approver2_id" id="approver2_id"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                    <option value="">-- Pilih Approver 2 --</option>
                    @foreach ($approvers as $approver)
                        @if (old('approver1_id') != $approver->id)
                            <option value="{{ $approver->id }}"
                                {{ old('approver2_id') == $approver->id ? 'selected' : '' }}>
                                {{ $approver->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="flex flex-wrap gap-2 pt-2">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded shadow">
                    Kirim Pemesanan
                </button>
                <a href="{{ route('pemesanan.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium px-5 py-2 rounded shadow">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let tanggalMulai = flatpickr("#tanggal_mulai", {
                dateFormat: "Y-m-d",
                disable: [],
                onDayCreate: highlightDisabledDates
            });

            let tanggalSelesai = flatpickr("#tanggal_selesai", {
                dateFormat: "Y-m-d",
                disable: [],
                onDayCreate: highlightDisabledDates
            });

            const kendaraanSelect = document.getElementById('kendaraan_id');

            kendaraanSelect.addEventListener('change', function() {
                const kendaraanId = this.value;

                if (!kendaraanId) return;

                const a = fetch(`{{ route('pemesanan.bookedDates') }}?kendaraan_id=${kendaraanId}`)
                    .then(res => res.json())
                    .then(data => {
                        tanggalMulai.set('disable', data);
                        tanggalSelesai.set('disable', data);
                        tanggalMulai.redraw();
                        tanggalSelesai.redraw();
                    })
                    .catch(err => console.error('Error fetching disabled dates:', err));
            });
            console.log(a)

            function highlightDisabledDates(dObj, dStr, fp, dayElem) {
                const date = dayElem.dateObj.toISOString().slice(0, 10); // "YYYY-MM-DD"
                const disabled = fp.config.disable;
                const isDisabled = disabled.some(range =>
                    typeof range === 'object' && range.from && range.to &&
                    date >= range.from && date <= range.to
                );
                if (isDisabled) {
                    dayElem.style.backgroundColor = '#f87171'; // merah
                    dayElem.style.color = 'white';
                    dayElem.style.borderRadius = '6px';
                }
            }
        });
    </script>
@endsection
