<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

/**
 * Toko LPSKE: katalog produk komersial, halaman detail, dan form pesanan.
 *
 * Belum memakai gateway pembayaran — pesanan tercatat berstatus "baru" dan
 * ditindaklanjuti admin dari panel (Toko — Pesanan).
 */
class TokoController extends Controller
{
    public function index()
    {
        $products = Product::active()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->get();

        return view('toko.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $lainnya = Product::active()
            ->whereKeyNot($product->getKey())
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('toko.show', [
            'product' => $product,
            'lainnya' => $lainnya,
            'whatsapp' => config('toko.whatsapp'),
        ]);
    }

    public function pesan(Request $request, Product $product)
    {
        abort_unless($product->is_active, 404);

        $data = $request->validate([
            'nama_pemesan' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:1000'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:100'],
            'catatan' => ['nullable', 'string', 'max:2000'],
        ], [], [
            'nama_pemesan' => 'nama',
            'telepon' => 'telepon/WhatsApp',
        ]);

        ProductOrder::create($data + [
            'product_id' => $product->id,
            'harga_saat_pesan' => $product->harga,
        ]);

        return redirect()
            ->route('toko.show', $product)
            ->with('pesan_sukses', 'Pesanan Anda sudah kami terima. Tim LPSKE akan menghubungi Anda lewat telepon/WhatsApp untuk konfirmasi dan detail pembayaran.');
    }
}
