<?php

namespace App\Http\Controllers\API;

use App\Models\Karyawan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    //
    public static function getKaryawanData($karyawanId)
    {
        $karyawan = Karyawan::find($karyawanId);

        if ($karyawan) {
            return [
                'id' => $karyawan->id,
                'nama' => $karyawan->nama,
                // Tambahkan data karyawan lainnya sesuai kebutuhan
            ];
        } else {
            return null;
        }
    }
}
