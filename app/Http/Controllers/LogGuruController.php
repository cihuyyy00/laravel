<?php

namespace App\Http\Controllers;

use App\Models\c;
use Illuminate\Http\Request;

class LogGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        return view('sekolah.user.register');
    }

    public function create(Request $request)
    {

            try {
            $request->validate([
                'name'      => 'required',
                'password'  => 'required', 
                'role'      => 'nullable'
            ]);

            // simpen data 
            User::create([
                'name'      => $request->name,
                'role'      => 'user',
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
    public function show(c $c)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(c $c)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, c $c)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(c $c)
    {
        //
    }
}
