<?php

namespace App\Http\Controllers;

use App\Models\PemesananKendaraan;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananKendaraanController extends Controller
{
    public function index()
    {
        $pemesanan = PemesananKendaraan::with(['user', 'kendaraan', 'approver1', 'approver2'])->get();
        $pending = $pemesanan->filter(fn($it) => strtolower($it->status) == "pending");

        return view('pemesanan.index', ["pemesanan" => $pemesanan, "pending" => $pending]);
    }

    public function create()
    {
        $kendaraans = Kendaraan::all();
        $approvers = User::where('role', 'approver')->get();

        return view('pemesanan.create', compact('kendaraans', 'approvers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'driver' => 'required|string',
            'approver1_id' => 'required|exists:users,id',
            'approver2_id' => 'nullable|exists:users,id|different:approver1_id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'required|string',
        ]);

        PemesananKendaraan::create([
            'user_id' => Auth::id(),
            'kendaraan_id' => $request->kendaraan_id,
            'driver' => $request->driver,
            'approver1_id' => $request->approver1_id,
            'approver2_id' => $request->approver2_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keperluan' => $request->keperluan,
            'status' => 'pending',
        ]);

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function show(PemesananKendaraan $pemesanan)
    {
        return view('pemesanan.show', compact('pemesanan'));
    }

    public function edit(PemesananKendaraan $pemesanan)
    {
        $kendaraans = Kendaraan::all();
        $approvers = User::where('role', 'approver')->get();

        return view('pemesanan.edit', compact('pemesanan', 'kendaraans', 'approvers'));
    }

    public function update(Request $request, PemesananKendaraan $pemesanan)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'driver' => 'required|string',
            'approver1_id' => 'required|exists:users,id',
            'approver2_id' => 'nullable|exists:users,id|different:approver1_id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'required|string',
        ]);

        $pemesanan->update([
            'kendaraan_id' => $request->kendaraan_id,
            'driver' => $request->driver,
            'approver1_id' => $request->approver1_id,
            'approver2_id' => $request->approver2_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keperluan' => $request->keperluan,
        ]);

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil diperbarui.');
    }

    public function destroy(PemesananKendaraan $pemesanan)
    {
        $pemesanan->delete();
        return redirect()->route('pemesanan.index')->with('success', 'Data berhasil dihapus.');
    }
}
