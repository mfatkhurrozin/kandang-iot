<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RelayController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CetakController;
use App\Http\Middleware\CekUser;

Route::get('/', [LayoutController::class, 'index'])->middleware('auth');
Route::get('/home', [LayoutController::class, 'index'])->middleware('auth');

Route::controller(LoginController::class)->group(function (){
    Route::get('login', 'index')->name('login');
    Route::post('login/proses', 'proses');
    Route::get('logout', 'logout');
});

Route::group(['middleware' => ['auth']],function(){
    Route::group(['middleware' => ['cekUser:1']],function(){
        // Grafik
        Route::get('chart-data', [ChartController::class, 'indexChart']);
       
        //Laporan
        Route::get('laporan-data', [LaporanController::class, 'indexLaporan']);
        Route::get('laporan-data', [LaporanController::class,'indexLaporan'])->name('filter-data');
        Route::get('laporan-data/cetak-pdf', [LaporanController::class, 'cetakPDF'])->name('laporan.pdf');


        //CetakPdf
        Route::get('cetak-pdf', [CetakController::class, 'cetakSemuaPdf']);
        Route::get('generate-pdf',  [CetakController::class, 'cetakPdf'])->name('generate.pdf');
        Route::get('cetak-tanggal', [CetakController::class, 'cetakTanggal']);
        
        Route::get('tabel-data', [SensorDataController::class, 'indexTable']);
        Route::get('tabel-data', [SensorDataController::class, 'indexTable'])->name('filter.data');
        Route::get('cetak-pdf/{inputtanggalAwal}/{inputtanggalAkhir}', [SensorDataController::class, 'cetakByDatePdf'])->name('cetak.date.pdf');
    

        //KelolaUser
        Route::get('user-data', [UserController::class, 'index']);
        Route::get('add-user', [UserController::class, 'create']);
        Route::post('add-user', [UserController::class, 'store']);
        Route::get('edit-user/{id}', [UserController::class, 'edit']);
        Route::put('update-user/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('delete-user/{id}', [UserController::class, 'delete'])->name('users.destroy');
    });

    Route::group(['middleware' => ['cekUser:2']],function(){
        Route::resource('sensors', SensorController::class);
        Route::post('add-sensor', [SensorController::class, 'store']);
        
        Route::resource('relays', RelayController::class);
        Route::get('edit-relay/{id}', [RelayController::class, 'edit']);
        Route::put('update-relay/{id}', [RelayController::class, 'update']);
    });
});