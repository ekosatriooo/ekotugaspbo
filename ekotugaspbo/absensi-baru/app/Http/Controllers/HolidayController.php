<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::orderBy('holiday_date', 'asc')->get();
        return view('admin.menu.libur', compact('holidays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'holiday_date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        Holiday::create($request->all());

        return redirect()->back()->with('success', 'Hari libur berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Holiday::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Hari libur berhasil dihapus!');
    }
}
