<?php

namespace App\Http\Controllers\API;

use App\Models\Cuti;
use App\Models\Karyawan;
use App\Http\Controllers\API\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CutiController extends Controller
{
    public function create(Request $request)
    {
        // Validasi data pengajuan cuti
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'alamat'=>'required|string',
            'jenis_cuti'=>'required|string'
        ]);

        // Ambil data karyawan dari KaryawanController
        $karyawanData = KaryawanController::getKaryawanData($request->input('karyawan_id'));

        // Jika karyawan ditemukan, buat pengajuan cuti
        if ($karyawanData) {
            $cuti = Cuti::create([
                'karyawan_id' => $request->input('karyawan_id'),
                'nama_karyawan' => $karyawanData['nama'], // Gantilah dengan nama kolom yang sesuai
                'tanggal_mulai' => $request->input('tanggal_mulai'),
                'tanggal_selesai' => $request->input('tanggal_selesai'),
                'alasan' => $request->input('alasan'),
                'alamat' => $request->input('address'),
                'jenis_cuti'=>$request->input('jenis_cuti')
            ]);

            // Tambahkan log atau notifikasi jika diperlukan

            return response()->json(['message' => 'Pengajuan cuti berhasil disimpan', 'data' => $cuti], 201);
        } else {
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }
    }

    public function updateCuti(Request $request, string $id)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'alamat'=>'required|string',
            'jenis_cuti'=>'required|string'
        ]);

        // Cek apakah data cuti dengan ID yang diberikan ada
        $cuti = Cuti::find($id);

        if (!$cuti) {
            return response()->json(['message' => 'Data cuti tidak ditemukan'], 404);
        }

        // Update data cuti
        $cuti->update([
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'alasan' => $request->input('alasan'),
            'alamat' => $request->input('address'),
            'jenis_cuti'=>$request->input('jenis_cuti')
        ]);

        // Tambahkan log atau notifikasi jika diperlukan

        return response()->json(['message' => 'Data cuti berhasil diperbarui', 'data' => $cuti], 200);
    }

    public function generatePDF(Request $request, string $id)
    {
        $cuti = Cuti::with('karyawan')->find($id);

        if($request->has('download'))
	    {
	        $pdf = PDF::loadView('index',$cuti);
	        return $pdf->download('users_pdf_example.pdf');
	    }

	    return view('generatePDF',compact('cuti'));
    }
}
