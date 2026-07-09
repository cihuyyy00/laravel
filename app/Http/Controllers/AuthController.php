<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.register');
    }

    public function create(Request $request)
    {

            try {
            $request->validate([
                'name'      => 'required',
                'email'     => 'required|email|unique:users',
                'password'  => 'required', 
                'role'      => 'nullable'
            ]);

            // simpen data 
            User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'role'      => $request->role,
                'password'  => Hash::make($request->password)
            ]);
            return redirect()->route('admin.user')->with('success', 'User berhasil dibuat');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Aksi gagal');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
