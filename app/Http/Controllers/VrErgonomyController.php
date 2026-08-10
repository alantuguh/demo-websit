<?php

namespace App\Http\Controllers;

use App\Models\VrModule;
use App\Models\VrRoom;
use Illuminate\Http\Request;

class VrErgonomyController extends Controller
{
    /**
     * Halaman utama VR Ergonomy Lab: penjelasan konsep, denah ruang, dan
     * katalog modul yang bisa disaring per ruang lewat ?ruang={slug}.
     */
    public function index(Request $request)
    {
        $rooms = VrRoom::active()
            ->withCount(['activeModules as modules_count'])
            ->orderBy('sort_order')
            ->get();

        $slugAktif = $request->query('ruang');
        $roomAktif = $slugAktif ? $rooms->firstWhere('slug', $slugAktif) : null;

        $modules = VrModule::active()
            ->with('room')
            // Slug yang tidak dikenal diperlakukan sebagai "tanpa filter",
            // bukan 404, supaya tautan lama tidak mematikan halaman.
            ->when($roomAktif, fn ($query) => $query->where('vr_room_id', $roomAktif->id))
            ->orderBy('sort_order')
            ->orderBy('judul')
            ->get();

        return view('vr-ergonomy.index', [
            'rooms' => $rooms,
            'modules' => $modules,
            'roomAktif' => $roomAktif,
            'levelOptions' => VrModule::levelOptions(),
            'statusOptions' => VrModule::statusOptions(),
            'totalModul' => VrModule::active()->count(),
            'totalTersedia' => VrModule::active()->where('status', 'tersedia')->count(),
        ]);
    }

    /**
     * Halaman satu ruang beserta seluruh modul di dalamnya.
     */
    public function show(VrRoom $vrRoom)
    {
        abort_unless($vrRoom->is_active, 404);

        $vrRoom->load(['activeModules' => fn ($query) => $query->orderBy('sort_order')]);

        $roomLain = VrRoom::active()
            ->where('id', '!=', $vrRoom->id)
            ->orderBy('sort_order')
            ->get();

        return view('vr-ergonomy.room', [
            'room' => $vrRoom,
            'modules' => $vrRoom->activeModules,
            'roomLain' => $roomLain,
            'levelOptions' => VrModule::levelOptions(),
            'statusOptions' => VrModule::statusOptions(),
        ]);
    }
}
