<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 

class KelasController extends Controller
{
    public function index()
    {
        // Urutkan berdasarkan tingkat kelas dulu baru nama kelas
        $kelas = Kelas::orderBy('kelas', 'asc')->orderBy('nama_kelas', 'asc')->get();
        return view('admin.menu.kelas', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'nama_kelas' => [
                'required',
                // Logika: Unik jika kombinasi 'kelas' DAN 'nama_kelas' belum ada
                Rule::unique('kelas')->where(function ($query) use ($request) {
                    return $query->where('kelas', $request->kelas)
                                 ->where('nama_kelas', $request->nama_kelas);
                }),
            ],
            'jurusan' => 'required'
        ], [
            'nama_kelas.unique' => 'Nama kelas ' . $request->nama_kelas . ' sudah ada di kelas ' . $request->kelas . '!',
        ]);

        Kelas::create($request->only(['kelas', 'nama_kelas', 'jurusan']));
        return back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas' => 'required',
            'nama_kelas' => [
                'required',
                // Logika: Unik tapi abaikan ID yang sedang diedit
                Rule::unique('kelas')->ignore($id)->where(function ($query) use ($request) {
                    return $query->where('kelas', $request->kelas)
                                 ->where('nama_kelas', $request->nama_kelas);
                }),
            ],
            'jurusan' => 'required'
        ], [
            'nama_kelas.unique' => 'Nama Kelas ' . $request->nama_kelas . ' di Kelas ' . $request->kelas. ' sudah ada!',
            'nama_kelas.required' => 'Nama kelas tidak boleh kosong!',
            'jurusan.required' => 'Jurusan tidak boleh kosong!',
        ]); 

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->only(['kelas', 'nama_kelas', 'jurusan']));

        return back()->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return back()->with('success', 'Kelas berhasil dihapus!');
    }
}