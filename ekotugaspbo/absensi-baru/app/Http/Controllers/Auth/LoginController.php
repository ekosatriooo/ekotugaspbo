<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // Memberitahu Laravel bahwa field utama login adalah 'nisn'
    public function username()
    {
        return 'nisn';
    }

    // Logika agar bisa login pakai NISN (Siswa) atau Email (Admin/Staf)
    protected function credentials(Request $request)
    {
        // Cek apakah input mengandung format email
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'nisn';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

    protected function authenticated(Request $request, $user)
    {
        
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'petugas') {
            return redirect()->route('petugas.dashboard');
        } elseif ($user->role == 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        
        return redirect('/home');
    }
}