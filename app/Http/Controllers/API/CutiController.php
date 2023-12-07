<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        // Ambil data karyawan dari database
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();

        if (!$karyawan) {
            return response()->json(['message' => 'Data karyawan tidak ditemukan'], 404);
        }

        // Simpan pengajuan cuti ke dalam database
        $cuti = Cuti::create([
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'reason' => $request->input('reason'),
            'prove' => $request->input('proves'),
            'user_id' => auth()->user()->id,
            'karyawan_id' => $karyawan->id, // Menghubungkan pengajuan cuti dengan data karyawan
        ]);

        return response()->json(['message' => 'Pengajuan cuti berhasil diajukan', 'cuti' => $cuti], 201);
    }

    public function updateCuti(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|string|max:255',
            'end_date' => 'nullable|string|max:255',
            'reason' => 'nullable|file',
            'prove' => 'nullable|file',
        ]);
        return response()->json(['message' => 'Pengajuan cuti berhasil dieditn', 'cuti' => $cuti], 201);
    }
}
