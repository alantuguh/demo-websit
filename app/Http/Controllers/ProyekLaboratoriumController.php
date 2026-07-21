<?php

namespace App\Http\Controllers;

use App\Models\ProyekLaboratorium;
use Illuminate\Http\Request;

class ProyekLaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource, dengan filter kategori opsional.
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $kategoriOptions = ProyekLaboratorium::kategoriOptions();

        $proyek = ProyekLaboratorium::active()
            ->when($kategori && array_key_exists($kategori, $kategoriOptions), function ($query) use ($kategori) {
                $query->kategori($kategori);
            })
            ->orderBy('sort_order')
            ->orderByDesc('tahun')
            ->paginate(12)
            ->withQueryString();

        return view('proyek-laboratorium.index', [
            'proyek' => $proyek,
            'kategoriOptions' => $kategoriOptions,
            'statusOptions' => ProyekLaboratorium::statusOptions(),
            'kategoriAktif' => $kategori,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProyekLaboratorium $proyekLaboratorium)
    {
        abort_unless($proyekLaboratorium->is_active, 404);

        $relatedItems = ProyekLaboratorium::active()
            ->kategori($proyekLaboratorium->kategori)
            ->where('id', '!=', $proyekLaboratorium->id)
            ->orderByDesc('tahun')
            ->take(3)
            ->get();

        return view('proyek-laboratorium.show', [
            'proyekLaboratorium' => $proyekLaboratorium,
            'relatedItems' => $relatedItems,
            'kategoriOptions' => ProyekLaboratorium::kategoriOptions(),
            'statusOptions' => ProyekLaboratorium::statusOptions(),
        ]);
    }
}
