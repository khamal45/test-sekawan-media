<?php

namespace App\Http\Controllers;

use App\Models\PemesananKendaraan;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pending = PemesananKendaraan::with(['user', 'kendaraan'])
            ->where(function ($query) use ($user) {
                $query->where('approver1_id', $user->id)
                    ->where('status', 'pending');
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('approver2_id', $user->id)
                    ->where('status', 'menunggu approver 2');
            })
            ->get();

        $approved = PemesananKendaraan::with(['user', 'kendaraan'])
            ->where(function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('approver1_id', $user->id)
                        ->orWhere('approver2_id', $user->id);
                })
                    ->whereIn('status', ['approved', 'menunggu approver 2']);
            })
            ->get();

        $rejected = PemesananKendaraan::with(['user', 'kendaraan'])
            ->where(function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('approver1_id', $user->id)
                        ->orWhere('approver2_id', $user->id);
                })
                    ->where('status', 'rejected');
            })
            ->get();

        return view('approval.index', compact('pending', 'approved', 'rejected'));
    }

    public function approve($id)
    {
        $user = Auth::user();
        $pemesanan = PemesananKendaraan::findOrFail($id);

        if (
            $pemesanan->approver1_id &&
            $pemesanan->approver2_id &&
            $pemesanan->approver1_id === $pemesanan->approver2_id
        ) {
            return back()->with('error', 'Approver 1 dan Approver 2 tidak boleh user yang sama.');
        }

        if (is_null($pemesanan->approver2_id)) {
            if ($user->id === $pemesanan->approver1_id && $pemesanan->status === 'pending') {
                $pemesanan->status = 'approved';
                $pemesanan->save();
                return back()->with('success', 'Pemesanan disetujui.');
            } else {
                return back()->with('error', 'Kamu tidak memiliki hak untuk menyetujui permintaan ini.');
            }
        }

        if ($user->id === $pemesanan->approver1_id && $pemesanan->status === 'pending') {
            $pemesanan->status = 'menunggu approver 2';
            $pemesanan->save();
            return back()->with('success', 'Pemesanan telah disetujui. Menunggu persetujuan approver 2.');
        }

        if ($user->id === $pemesanan->approver2_id && $pemesanan->status === 'menunggu approver 2') {
            $pemesanan->status = 'approved';
            $pemesanan->save();
            return back()->with('success', 'Pemesanan berhasil disetujui.');
        }

        return back()->with('error', 'Kamu tidak memiliki hak atau status tidak valid untuk menyetujui permintaan ini.');
    }

    public function reject($id)
    {
        $user = Auth::user();
        $pemesanan = PemesananKendaraan::findOrFail($id);

        if (
            $pemesanan->approver1_id &&
            $pemesanan->approver2_id &&
            $pemesanan->approver1_id === $pemesanan->approver2_id
        ) {
            return back()->with('error', 'Approver 1 dan Approver 2 tidak boleh user yang sama.');
        }

        if ($user->id === $pemesanan->approver1_id && $pemesanan->status === 'pending') {
            $pemesanan->status = 'rejected';
            $pemesanan->save();
            return back()->with('success', 'Pemesanan berhasil ditolak oleh Approver 1.');
        }

        if ($user->id === $pemesanan->approver2_id && $pemesanan->status === 'menunggu approver 2') {
            $pemesanan->status = 'rejected';
            $pemesanan->save();
            return back()->with('success', 'Pemesanan berhasil ditolak oleh Approver 2.');
        }

        return back()->with('error', 'Kamu tidak memiliki hak atau status tidak valid untuk menolak permintaan ini.');
    }
}
