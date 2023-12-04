<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dokumenontroller extends Controller
{
    public function upload(Request $request)
    {
        // Validasi input
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:2048', // Contoh: Hanya mendukung PDF, DOC, dan DOCX, maksimal 2MB
        ]);

        // Ambil file yang diunggah
        $file = $request->file('file');

        // Simpan file ke penyimpanan (storage)
        $path = $file->store('dokumen');

        // Logika untuk menyimpan data file ke database pengguna
        // Misalnya: auth()->user()->dokumen()->create(['path' => $path]);

        return response()->json(['message' => 'File berhasil diunggah', 'path' => $path], 201);
    }
}
