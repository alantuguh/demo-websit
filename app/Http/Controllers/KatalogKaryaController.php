<?php

namespace App\Http\Controllers;

use App\Models\KaryaLab;
use Illuminate\Http\Request;

class KatalogKaryaController extends Controller
{
    /**
     * Display a listing of the resource, dengan filter kategori opsional.
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $kategoriOptions = KaryaLab::kategoriOptions();

        $karya = KaryaLab::active()
            ->when($kategori && array_key_exists($kategori, $kategoriOptions), function ($query) use ($kategori) {
                $query->kategori($kategori);
            })
            ->orderBy('sort_order')
            ->orderByDesc('tahun')
            ->paginate(12)
            ->withQueryString();

        return view('katalog-karya.index', [
            'karya' => $karya,
            'kategoriOptions' => $kategoriOptions,
            'kategoriAktif' => $kategori,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(KaryaLab $karyaLab)
    {
        abort_unless($karyaLab->is_active, 404);

        $relatedItems = KaryaLab::active()
            ->kategori($karyaLab->kategori)
            ->where('id', '!=', $karyaLab->id)
            ->orderByDesc('tahun')
            ->take(3)
            ->get();

        return view('katalog-karya.show', [
            'karyaLab' => $karyaLab,
            'relatedItems' => $relatedItems,
            'kategoriOptions' => KaryaLab::kategoriOptions(),
        ]);
    }
}
