<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GrafikPemakaianController extends Controller
{
    public function index()
    {
        $kendaraanList = DB::table('kendaraans')->pluck('nama', 'id');

        // Status yang digunakan dalam sistem saat ini
        $statuses = ['pending', 'menunggu approver 2', 'approved'];

        $data = [];

        foreach ($statuses as $status) {
            $data[$status] = DB::table('pemesanan_kendaraans')
                ->select('kendaraan_id', DB::raw('COUNT(*) as total'))
                ->where('status', $status)
                ->groupBy('kendaraan_id')
                ->pluck('total', 'kendaraan_id')
                ->toArray();
        }

        $labels = $kendaraanList->values(); // nama kendaraan
        $kendaraanIds = $kendaraanList->keys(); // id kendaraan
        $totalsPerStatus = [];

        foreach ($statuses as $status) {
            $totals = [];
            foreach ($kendaraanIds as $id) {
                $totals[] = $data[$status][$id] ?? 0;
            }
            $totalsPerStatus[$status] = $totals;
        }

        return view('grafik.index', compact('labels', 'totalsPerStatus'));
    }
}
