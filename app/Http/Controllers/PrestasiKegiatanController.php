<?php

namespace App\Http\Controllers;

use App\Models\PrestasiKegiatan;
use Illuminate\Http\Request;

class PrestasiKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasi = PrestasiKegiatan::where('is_active', true)
            ->where('jenis', 'prestasi')
            ->orderBy('tanggal', 'desc')
            ->paginate(12, ['*'], 'prestasi_page');
            
        $kegiatan = PrestasiKegiatan::where('is_active', true)
            ->where('jenis', 'kegiatan')
            ->orderBy('tanggal', 'desc')
            ->paginate(12, ['*'], 'kegiatan_page');
            
        return view('prestasi-kegiatan.index', compact('prestasi', 'kegiatan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PrestasiKegiatan $prestasiKegiatan)
    {
        $relatedItems = PrestasiKegiatan::where('jenis', $prestasiKegiatan->jenis)
            ->where('id', '!=', $prestasiKegiatan->id)
            ->where('is_active', true)
            ->orderBy('tanggal', 'desc')
            ->take(3)
            ->get();
            
        return view('prestasi-kegiatan.show', compact('prestasiKegiatan', 'relatedItems'));
    }
}
