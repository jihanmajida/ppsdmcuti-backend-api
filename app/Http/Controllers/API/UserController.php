<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //function login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Invalid input'], 401);
        }
    }

    public function fetch()
    {
        $user = User::with('karyawan')->find(Auth::user()->id);

        return ResponseFormatter::success([
            'user' => $user,
        ], 'Data pengguna ditemukan.', 200);
    }

    //profile
    public function profile()
    {
        $user = auth()->user(); // Mengambil informasi pengguna yang terotentikasi

        if ($user) {
            // Jika pengguna ditemukan, kembalikan data profil
            return response()->json(['user' => $user], 200);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan pesan kesalahan
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function logout(Request $request) {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success([
            'token' => $token,
        ], 'Berhasil keluar.', 200);
    }

}
