<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemesananKendaraan;
use Carbon\Carbon;

class BookingTanggalController extends Controller
{
    public function bookedDates(Request $request)
    {
        // Sementara untuk test awal
        // return response()->json(['hello' => 'world']);

        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
        ]);

        $bookings = PemesananKendaraan::where('kendaraan_id', $request->kendaraan_id)
            ->whereIn('status', ['pending', 'menunggu approver 2', 'approved'])
            ->get(['tanggal_mulai', 'tanggal_selesai']);

        $ranges = $bookings->map(fn($b) => [
            'from' => Carbon::parse($b->tanggal_mulai)->format('Y-m-d'),
            'to' => Carbon::parse($b->tanggal_selesai)->format('Y-m-d'),
        ]);

        return response()->json($ranges);
    }
}
