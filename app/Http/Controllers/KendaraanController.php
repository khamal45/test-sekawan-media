<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::latest()->get();
        return view('kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:angkutan orang,angkutan barang',
            'tipe' => 'required|in:milik,sewaan',
            'no_polisi' => 'required|string|max:20|unique:kendaraans,no_polisi',
            'region' => 'required|string|max:255',
            'konsumsi_bbm' => 'required|numeric|min:0',
            'jadwal_service_berikutnya' => 'required|date',
        ]);

        Kendaraan::create($request->all());

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    public function show(Kendaraan $kendaraan)
    {
        return view('kendaraan.show', compact('kendaraan'));
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:angkutan orang,angkutan barang',
            'tipe' => 'required|in:milik,sewaan',
            'no_polisi' => 'required|string|max:20|unique:kendaraans,no_polisi,' . $kendaraan->id,
            'region' => 'required|string|max:255',
            'konsumsi_bbm' => 'required|numeric|min:0',
            'jadwal_service_berikutnya' => 'required|date',
        ]);

        $kendaraan->update($request->all());

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil dihapus.');
    }
}
