<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // AMBIL ROLE USER YANG LOGIN
        $role = Auth::user()->role;

        // TENDANG KE DASHBOARD MASING-MASING
        if ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role == 'petugas') {
            return redirect()->route('petugas.dashboard');
        } elseif ($role == 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        // Kalau role ga jelas, balik ke login
        Auth::logout();
        return redirect('/login');
    }
}