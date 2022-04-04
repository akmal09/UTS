<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('portallaravel');
});

// Karena menggunakan 2 tabel pada database, maka saya menggunakan 2 get_matakuliah yaitu untuk dalam prodi dan luar prodi 
Route::get('/get_matakuliah_dalam_prodi', [App\Http\Controllers\MatkulProdiController::class,'get_matakuliah_dalam_prodi']);
Route::get('/get_matakuliah_luar_prodi', [App\Http\Controllers\MatkulProdiController::class,'get_matakuliah_luar_prodi']);

