<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    //function login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        try {
            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error('Email atau password salah. Autentikasi gagal.', 401);
            }

            $user = User::where('email', $request->input('email'))->with('karyawan')->first();

            if (!Hash::check($request->input('password'), $user->password, [])) {
                throw new Exception('Invalid credentials');
            }

            if ($user->disabled_at) {
                return ResponseFormatter::error('Status pengguna tidak aktif. Hubungi Admin apabila ada kesalahan.', 400);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Berhasil masuk', 200);
        } catch (Exception $error) {
            return ResponseFormatter::error('Ada yang Salah. Autentikasi gagal.'  . $error, 500);
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
