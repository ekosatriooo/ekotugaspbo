<?php

namespace App\Http\Controllers;

use App\Models\JamAbsen;
use Illuminate\Http\Request;

class JamAbsenController extends Controller
{
    public function index()
    {
        // Ambil data jam masuk dan pulang
        $jamMasuk = JamAbsen::where('tipe', 'masuk')->first();
        $jamPulang = JamAbsen::where('tipe', 'pulang')->first();

        return view('admin.menu.jam_absen', compact('jamMasuk', 'jamPulang'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,pulang',
            'mulai' => 'required',
            'selesai' => 'required',
        ]);

        // Update atau buat baru kalau belum ada datanya (UpdateOrCreate)
        JamAbsen::updateOrCreate(
            ['tipe' => $request->tipe],
            [
                'mulai' => $request->mulai,
                'selesai' => $request->selesai
            ]
        );

        return back()->with('success', "Jam Absen " . ucfirst($request->tipe) . " berhasil diperbarui!");
    }
}