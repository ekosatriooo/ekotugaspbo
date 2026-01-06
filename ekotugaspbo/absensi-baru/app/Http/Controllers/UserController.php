<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() 
    {

       $users = \App\Models\User::where('id', '!=', auth()->id())
                ->whereIn('role', ['admin', 'petugas', 'guru']) // Tambahkan baris ini
                ->get();
        return view('admin.menu.users', compact('users'));

    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Role user ' . $user->name . ' berhasil diubah!');
    }

    public function updatePermission(Request $request)
    {
    $permission = \App\Models\Permission::updateOrCreate(
        [
            'role' => $request->role, 
            'menu_name' => $request->menu
        ],
        [
            'is_accessible' => $request->status == 'true' ? 1 : 0
        ]
    );

    return response()->json(['success' => true, 'message' => 'Akses Berhasil Diubah!']);
    }


    public function adminDashboard()
    {
        $data = [
            'countIzin'  => \App\Models\Izin::count(),
            'countSiswa' => \App\Models\Siswa::count(),
            'countUser'  => \App\Models\User::count(),
            'countKelas' => \App\Models\Kelas::count(),
        ];

        return view('admin.dashboard', $data);
    }

    public function petugasDashboard()
    {
        
        $countIzin   = \App\Models\Izin::count();
        $countSiswa  = \App\Models\Siswa::count();
        $countUser   = \App\Models\User::count();
        $countKelas  = \App\Models\Kelas::count();

        // Kirim data ke view petugas
        return view('petugas.dashboard', compact('countIzin', 'countSiswa', 'countUser', 'countKelas'));
    }

}
