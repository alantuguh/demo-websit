<?php

namespace App\Http\Controllers;

use App\Models\MuseSession;
use Illuminate\Http\Request;

/**
 * Muse Lab: pemantauan EEG headband Muse (muse-js, Web Bluetooth) dengan
 * interpretasi neuro-ergonomi. Halaman monitor berdiri sendiri (dashboard
 * layar penuh); server hanya menerima ringkasan sesi untuk diarsip.
 */
class MuseLabController extends Controller
{
    public function index()
    {
        return view('muse-lab.index');
    }

    /**
     * Simpan ringkasan sesi dari browser (fetch JSON, lihat app.js).
     * Data mentah EEG tidak pernah dikirim ke server.
     */
    public function storeSession(Request $request)
    {
        $data = $request->validate([
            'nama_subjek' => ['required', 'string', 'max:255'],
            'aktivitas' => ['nullable', 'string', 'max:255'],
            'perangkat' => ['nullable', 'string', 'max:100'],
            'mode_demo' => ['required', 'boolean'],
            'mulai_pada' => ['required', 'date'],
            'durasi_detik' => ['required', 'integer', 'min:5', 'max:86400'],
            'ringkasan' => ['required', 'array'],
            'catatan' => ['nullable', 'string', 'max:2000'],
        ]);

        // Ringkasan disusun aplikasi dan ukurannya kecil; tolak muatan yang
        // janggal besarnya supaya endpoint publik ini tidak jadi tempat sampah.
        abort_if(strlen(json_encode($data['ringkasan'])) > 65536, 422, 'Ringkasan terlalu besar.');

        $session = MuseSession::create($data);

        return response()->json(['ok' => true, 'id' => $session->id]);
    }
}
