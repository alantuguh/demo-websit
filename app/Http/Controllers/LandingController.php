<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PrestasiKegiatan;
use App\Models\Team;
use App\Models\Logbook;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil 6 asisten terbaru untuk ditampilkan di halaman utama
        $asisten = Team::where('type', 'asisten')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        // Ambil 3 konten yang ditandai dengan bintang (featured)
        $featuredItems = PrestasiKegiatan::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('featured_at', 'desc')
            ->take(3)
            ->get();

        // Jika featured items kurang dari 3, ambil item terbaru
        if ($featuredItems->count() < 3) {
            $additionalItems = PrestasiKegiatan::where('is_active', true)
                ->whereNotIn('id', $featuredItems->pluck('id'))
                ->orderBy('created_at', 'desc')
                ->take(3 - $featuredItems->count())
                ->get();
                
            $featuredItems = $featuredItems->merge($additionalItems);
        }

        // Get the most recent logbook entries
        $recentLogbooks = Logbook::with('asisten')
            ->where('date', '>=', now()->subDays(7)) // Show logs from the last 7 days
            ->orderBy('date', 'desc')
            ->limit(5) // Limit to 5 most recent entries
            ->get();

        return view('landing.index', [
            'asisten' => $asisten,
            'featuredItems' => $featuredItems,
            'recentLogbooks' => $recentLogbooks,
        ]);
    }

    /**
     * Display the asisten laboratorium page.
     *
     * @param int|null $angkatan
     * @return \Illuminate\View\View
     */
    public function asistenLaboratorium($angkatan = null)
    {
        $activeMenu = 'asisten';
        
        // Query untuk mengambil data asisten aktif
        $query = Team::where('type', 'asisten')
            ->where('is_active', true)
            ->orderBy('name', 'asc');
        
        // Filter berdasarkan angkatan jika ada
        if ($angkatan) {
            $query->where('angkatan', $angkatan);
        }
        
        $asisten = $query->get();

        // Ambil daftar angkatan unik untuk filter
        $angkatanList = Team::where('type', 'asisten')
            ->where('is_active', true)
            ->distinct('angkatan')
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');

        // Ambil data kepala laboratorium
        $kepala = Team::where('type', 'kepala')
            ->where('is_active', true)
            ->first();

        // Ambil data dosen
        $dosen = Team::where('type', 'dosen')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('asisten-laboratorium.index', compact('asisten', 'activeMenu', 'angkatan', 'angkatanList', 'kepala', 'dosen'));
    }

    /**
     * Display kepala laboratorium page.
     *
     * @return \Illuminate\View\View
     */
    public function kepalaLaboratorium()
    {
        $activeMenu = 'kepala';
        
        // Ambil data kepala laboratorium aktif
        $kepala = Team::where('type', 'kepala')
            ->where('is_active', true)
            ->first();

        return view('asisten-laboratorium.index', compact('kepala', 'activeMenu'));
    }

    /**
     * Display dosen laboratorium page.
     *
     * @return \Illuminate\View\View
     */
    public function dosenLaboratorium()
    {
        $activeMenu = 'dosen';
        
        // Ambil data dosen aktif
        $dosen = Team::where('type', 'dosen')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('asisten-laboratorium.index', compact('dosen', 'activeMenu'));
    }

    /**
     * Display the dokumentasi page.
     *
     * @return \Illuminate\View\View
     */
    public function dokumentasi()
    {
        $activeMenu = 'dokumentasi';
        
        // Redirect ke halaman prestasi-kegiatan
        return redirect()->route('prestasi-kegiatan.index');
    }
    
    /**
     * Display asisten by angkatan.
     *
     * @param int $angkatan
     * @return \Illuminate\View\View
     */
    public function asistenByAngkatan($angkatan)
    {
        $activeMenu = 'asisten';
        
        // Query untuk mengambil data asisten berdasarkan angkatan
        $asisten = Team::where('type', 'asisten')
            ->where('is_active', true)
            ->where('angkatan', $angkatan)
            ->orderBy('name', 'asc')
            ->get();
            
        // Ambil daftar angkatan unik untuk filter
        $angkatanList = Team::where('type', 'asisten')
            ->where('is_active', true)
            ->distinct('angkatan')
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');

        // Ambil data kepala laboratorium
        $kepala = Team::where('type', 'kepala')
            ->where('is_active', true)
            ->first();

        // Ambil data dosen
        $dosen = Team::where('type', 'dosen')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('asisten-laboratorium.index', compact('asisten', 'activeMenu', 'angkatan', 'angkatanList', 'kepala', 'dosen'));
    }

    /**
     * Display kolaborator page.
     *
     * @return \Illuminate\View\View
     */
    public function kolaborator()
    {
        return view('kolaborator.index');
    }

    // Method prestasiKegiatan dipindahkan ke PrestasiKegiatanController
}
