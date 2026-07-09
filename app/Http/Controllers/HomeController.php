<?php
namespace App\Http\Controllers;

use illuminate\Http\Request;

class HomeController extends Controller {
    public function index() {
        $nama = 'Ajis';
        return view('home', ['nama' => $nama]); // kirim $nama ke view dg key 'nama'
    }
}

    