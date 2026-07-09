<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\SiswaController as ApiSiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BelajarController;
use App\Http\Controllers\DasborController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HaloController;
use App\Http\Controllers\HlmnController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LogGuruController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Imports\SiswaImport;
use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get ('/baru', [DasborController::class, 'index'])->name('dasbor.index');
Route::get ('/baru1', [DasborController::class, 'index1'])->name('dasbor.index1');
Route::get ('/baru2', [DasborController::class, 'index2'])->name('dasbor.index2');


Route::get('/absensi/pdfR', [AbsensiController::class, 'pdfRekap'])->name('absensi.pdfR');
Route::get('/absensi/expRekap', [AbsensiController::class, 'excelRekap'])->name('absensi.excelRekap');
Route::get('/absensi/export', [AbsensiController::class, 'excel'])->name('absensi.export');
Route::get('/absensi/pdf', [AbsensiController::class, 'pdf'])->name('absensi.pdf');
Route::get('/absensi/rekap', [AbsensiController::class, 'rekap'])->name('absensi.rekap');
Route::resource('absensi', AbsensiController::class);
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');

Route::post('/mapel{id}/guru', [MapelController::class, 'storeGuru'])->name('mapel.storeGuru');
Route::get('/mapel{id}/guru', [MapelController::class, 'addGuru'])->name('mapel.addGuru');
Route::get('/mapel', [MapelController::class, 'index'])->name('mapel.index');
Route::resource('mapel', MapelController::class);

Route::get('/dasbor', function () {
    return view('sekolah.dasbor');
})->name('dasboran')->middleware('isAdmin');


Route::post('/guru/{id}/mapel', [GuruController::class, 'storeMapel'])->name('guru.storeMapel');
Route::get('/guru/{id}/mapel', [GuruController::class, 'addMapel'])->name('guru.addMapel');
Route::resource('guru', GuruController::class);
Route::post('guru/tambah', [GuruController::class, 'store'])->name('guru.store');
Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');

Route::get('/kelas/tambah', [KelasController::class, 'create'])->name('kelas.create');
Route::post('/kelas/data', [KelasController::class, 'store'])->name('kelas.store');
Route::resource('kelas', KelasController::class);
Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');




Route::post('/siswa/import', [SiswaImport::class, 'import'])->name('siswa.import');
Route::get('/siswa/pdf', [SiswaController::class, 'exportPdf'])->name('siswa.pdf');
Route::get('/siswa/export', [SiswaController::class, 'export'])->name('siswa.export');
Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::resource('siswa', SiswaController::class);




// midlleware role

Route::middleware(['auth',
    'isAdmin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.user');
    });

Route::middleware(['auth',
    'isUser'])->group(function () {
        Route::get('/user', [RoleController::class, 'index'])->name('user.data');
    });


Route::get('/user/dasbor', function() {
    return view('role.user.index');
})->name('user.dasbor')->middleware('isUser');

Route::get('/admin/dasbor', function() {
    return view('role.admin.dasbor');
})->name('admin.dasbor')->middleware('isAdmin');

Route::post('/logout', function () {
    Auth::logout(); // hapus sesi login
    return redirect('/login'); 
})->name('logout');

// registrasi guru
Route::get('/regguru', [LogGuruController::class, 'index']);
Route::post('/regguru', [LogGuruController::class, 'create'])->name('regguru');

// registrasi user 
Route::get('/register', [AuthController::class, 'index'])->middleware('isAdmin');
Route::post('/register', [AuthController::class, 'create'])->name('register')->middleware('isAdmin');


// login/logout 
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login')->middleware('throttle:5,1');                                      # rate limit/batas login 5x dalam 1 menit
Route::post('/login', [LoginController::class, 'loginProses'])->name('login.proses');
Route::get('/login', [LoginController::class, 'index'])->name('login');

// GET biasa
Route::get('/belajar', function () {
    return 'Belajar laravel itu asik';
});

// make JSON
Route::get('/data',  function() {
    return ['nama' => 'Budi', 'kelas' => 10];
});

// make parameter
Route::get('/uadrat/{angka}', function($angka) {
    return $angka * $angka;
});

Route::get('/kali/{a}/{b}', function($a, $b) {
    return $a * $b;
});

// fallback buat error, misal g ada, ini yg keluar
// Route::fallback(function () {
//     return 'halaman g ketemu';
// });


Route::get('itung/{a1}/{a2}', [BelajarController::class, 'itung']);
Route::get('kuadrat/{b1}', [BelajarController::class, 'kuadrat']);



Route::get('/admin', function () {
    return 'Selamat Datang Admin!';
})->middleware('isAdmin');


// CRUD
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});

// dashboard
Route::get('/dashboard', [LoginController::class, 'dashboard'])->middleware('auth');





// Route::delete('/users/{id}', [UserController::class, 'hapus'])->name('users.hapus');
// Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
// // buat nampilin form & nyimpen datanya
// Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
// Route::post('/users/login', [UserController::class, 'login'])->name('users.login');

Route::resource('users', UserController::class);

Route::get('/user/{nama}/{umur}', function($nama, $umur) {
    return "Halo, nama kamu $nama, umur $umur";
});



Route::get('/admin/user', function () {
    return view('admin.user');
});

// Route::get('/admin/home', function () {
//     return view('admin.dasbor');
// });


Route::get('/halo',[HaloController::class, 'index'])->name('halo');

// Route::get('/', function () {
//     return 'welcome';
// });
?>