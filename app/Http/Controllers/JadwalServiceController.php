<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalServiceController extends Controller
{
    public function index()
    {
        // Tampilkan kendaraan dengan jadwal service berikutnya
        $kendaraans = Kendaraan::orderBy('jadwal_service_berikutnya', 'asc')->get();

        return view('service.index', compact('kendaraans'));
    }
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'tanggal_service' => 'required|date',
        ]);

        $tanggalService = Carbon::parse($request->tanggal_service);
        $jadwalBerikutnya = $tanggalService->copy()->addMonths(2);

        $kendaraan->update([
            'jadwal_service_terakhir' => $tanggalService,
            'jadwal_service_berikutnya' => $jadwalBerikutnya,
        ]);

        return redirect()->route('service.index')->with('success', 'Jadwal service berhasil diperbarui.');
    }
}
