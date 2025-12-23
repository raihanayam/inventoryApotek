<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk;
use App\Models\DetailObatMasuk;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ObatMasukController extends Controller
{
    public function index()
    {
        $obat_masuks = ObatMasuk::with([
            'user',
            'detail_obat_masuk.product.satuan'
        ])
        ->orderBy('Tanggal_Masuk', 'ASC')
        ->paginate(7);

        return view('pages.ObatMasuk.index', compact('obat_masuks'));
    }

    public function create()
    {
        return view('pages.ObatMasuk.create', [
            'products' => Product::all(),
            'user'     => Auth::user()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Tanggal_Masuk'                 => 'required|date',
            'items'                         => 'required|array|min:1',
            'items.*.product_id'            => 'required|exists:products,id',
            'items.*.Jumlah'                => 'required|integer|min:1',
            'items.*.Harga_Beli'            => 'required|numeric|min:0',
            'items.*.Tanggal_Kadaluwarsa'   => 'required|date',
        ]);

        DB::transaction(function () use ($request) {

            /** HEADER */
            $obat_masuk = ObatMasuk::create([
                'Id_User'        => Auth::id(),
                'Tanggal_Masuk'  => $request->Tanggal_Masuk,
                'Total'          => collect($request->items)->sum('Jumlah'),
            ]);

            $obat_masuk->Id_Masuk = 'M' . str_pad($obat_masuk->id, 3, '0', STR_PAD_LEFT);
            $obat_masuk->save();

            /** DETAIL */
            foreach ($request->items as $item) {

                $detail = DetailObatMasuk::create([
                    'obat_masuk_id'        => $obat_masuk->id,
                    'product_id'           => $item['product_id'],
                    'Jumlah'               => $item['Jumlah'],
                    'Harga_Beli'           => $item['Harga_Beli'],
                    'Tanggal_Kadaluwarsa'  => $item['Tanggal_Kadaluwarsa'],
                ]);

                $detail->Id_Detail_Masuk = 'DM' . str_pad($detail->id, 3, '0', STR_PAD_LEFT);
                $detail->save();

                /** TAMBAH STOK GLOBAL */
                $product = Product::find($item['product_id']);
                $product->stock += $item['Jumlah'];
                $product->save();
            }
        });

        return redirect('/masuk')->with('success', 'Obat masuk berhasil ditambahkan.');
    }

    public function show($id)
    {
        $obat_masuk = ObatMasuk::with([
            'user',
            'detail_obat_masuk.product.satuan'
        ])->findOrFail($id);

        return view('pages.ObatMasuk.show', compact('obat_masuk'));
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {

            $obat_masuk = ObatMasuk::with('detail_obat_masuk')->findOrFail($id);

            /** CEK: batch sudah dipakai atau belum */
            foreach ($obat_masuk->detail_obat_masuk as $detail) {

                $product = Product::find($detail->product_id);

                if ($product->stock < $detail->Jumlah) {
                    throw new \Exception(
                        'Data tidak dapat dihapus karena stok sudah digunakan.'
                    );
                }

                $product->stock -= $detail->Jumlah;
                $product->save();
            }

            $obat_masuk->detail_obat_masuk()->delete();
            $obat_masuk->delete();
        });

        return redirect('/masuk')->with('success', 'Data obat masuk berhasil dihapus.');
    }
}
