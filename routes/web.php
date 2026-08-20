<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LogbookController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])
    ->name('home');

// Asisten Laboratorium Routes
Route::prefix('asisten-laboratorium')->group(function () {
    Route::get('/', [LandingController::class, 'asistenLaboratorium'])->name('asisten-laboratorium');
    Route::get('/angkatan/{angkatan}', [LandingController::class, 'asistenByAngkatan'])->name('asisten.angkatan');
});

// Kepala Laboratorium
Route::get('/kepala-laboratorium', [LandingController::class, 'kepalaLaboratorium'])->name('kepala-laboratorium');

// Dosen Laboratorium
Route::get('/dosen-laboratorium', [LandingController::class, 'dosenLaboratorium'])->name('dosen-laboratorium');

// Prestasi & Kegiatan
Route::controller(\App\Http\Controllers\PrestasiKegiatanController::class)
    ->prefix('prestasi-kegiatan')
    ->name('prestasi-kegiatan.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{prestasiKegiatan}', 'show')->name('show');
    });

// Katalog Produk & Karya
Route::controller(\App\Http\Controllers\KatalogKaryaController::class)
    ->prefix('katalog-karya')
    ->name('katalog-karya.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{karyaLab}', 'show')->name('show');
    });

// Proyek Laboratorium (Wibawa, Jarpak, Semesta, DIKTI, Kerja Sama UNS)
Route::controller(\App\Http\Controllers\ProyekLaboratoriumController::class)
    ->prefix('proyek-laboratorium')
    ->name('proyek-laboratorium.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{proyekLaboratorium}', 'show')->name('show');
    });

// VR Ergonomy Lab — laboratorium virtual dengan ruang-ruang tematik.
// Ruang dirujuk lewat slug (lihat VrRoom::getRouteKeyName).
Route::controller(\App\Http\Controllers\VrErgonomyController::class)
    ->prefix('vr-ergonomy')
    ->name('vr-ergonomy.')
    ->group(function () {
        Route::get('/', 'index')->name('index');

        // Scene VR multiplayer sebuah ruang (A-Frame + Networked-A-Frame).
        Route::get('/{vrRoom}/vr', 'vr')->name('vr');

        Route::get('/{vrRoom}', 'show')->name('room');
    });

    // Kolaborator route
Route::get('/kolaborator', [LandingController::class, 'kolaborator'])
    ->name('kolaborator');

// Program PKL untuk siswa SMK
Route::get('/program-pkl', [LandingController::class, 'programPkl'])
    ->name('program-pkl');

    
// Logbook
Route::get('/recent-logbook', [LogbookController::class, 'getRecentLogbook'])->name('logbook.recent');

// Public route for alumni
Route::get('/alumni', [\App\Http\Controllers\AlumniStoryController::class, 'index'])
    ->name('public.alumni.index');

// Filament Panel POST Routes untuk Login
Route::post('admin/login', [\Filament\Pages\Auth\Login::class, 'authenticate'])
    ->middleware(['web'])
    ->name('filament.admin.auth.login.post');

Route::post('asisten/login', [\Filament\Pages\Auth\Login::class, 'authenticate'])
    ->middleware(['web'])
    ->name('filament.asisten.auth.login.post');

Route::post('anggota/login', [\Filament\Pages\Auth\Login::class, 'authenticate'])
    ->middleware(['web'])
    ->name('filament.anggota.auth.login.post');