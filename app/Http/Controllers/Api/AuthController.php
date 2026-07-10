<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register (Request $request) {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            'password'      => 'required',
            'role'          => 'nullable'
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Registrasi berhasil',
            'token'         => $token,
            'type'          => 'Bearer'
        ], 201);
    }
    public function login (Request $request) {
        $request->validate([
            'email'     => 'required',
            'password'  => 'required'
        ]);

        // autentikasi make email ama pw nya tdi
        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'        => 'error',
                'message'       => 'Email atau Password salah'
            ], 401);
        }

        /** @var User $user */
        $user   = Auth::user(); // ambil data user yg login 
        if (!$user) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'User tidak ditemukan setelah login'
            ], 500);
        }

        $user->tokens()->delete();
        $token  = $user->createToken('auth_token')->plainTextToken;  // bkin token baru tiap kali user login, trus ntar disimpen di db

        return response()->json([
            'status'    => 'success',
            'message'   => 'Login berhasil',
            'token'     => $token,
            'user'      => $user
        ]);
    }

    public function logout(Request $request) {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Logout berhasil'
            ]);
        }

        return response()->json([
            'message'   => 'User tidak ditemukan.'
        ], 401);
    }
}
