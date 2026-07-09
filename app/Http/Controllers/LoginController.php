<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController {

    public function index() {
        return view('login');
    }

    public function loginProses(Request $request) {
        // validasi data
        $kunci = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->back()->withErrors(['email' => 'Email or Password is wrong']);
        }
        
        // cek email ama pw ny ke db
        if (Auth::attempt($kunci)) {

            // bkin session bru
            $request->session()->regenerate();
            sleep(3);                           // biar ada delay sebelum login, brute force lambat

            // dump('login sukses');
            // dd(Auth::user());

            if(Auth::user()->role === 'admin') {
                return redirect()->route('admin.dasbor');
            } elseif(Auth::user()->role === 'user') {
                return redirect()->route('user.data');
            }
        }
    }

    public function dashboard() {
        return view('dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
} 