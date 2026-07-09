<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UserController extends Controller {
    
    // 1. fungsi tampilkan semua
    public function index () {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // 2. fungsi form tambah
    public function create () {
        return view('users.create');
    }

    // 3. fungsi simpen data baru
    public function store(Request $request) {
        // validasi input
        $validasi = $request->validate([
                                        'name'      => 'required|min:3',                            // min = miniml 3 karakter 
                                        'email'     => 'required|email|unique:users,email',         //unique = biar email ga sama
                                        'password'  => 'required',
                                        ]);
            
        // simpen ke db 
        User::create(['name' => $request->name,
                    'email' => $request->email, 
                    'password' => Hash::make($request->password,
)]);    
    return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    // 4. fungsi form edit
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // 5. fungsi update data
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|max:100', 
            'email' => 'required|email|unique:users,email,'. $id, 
            'password' => 'nullable'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }
    
    // 6. fungsi hapus
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete(); // hapus data
        
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}



?>