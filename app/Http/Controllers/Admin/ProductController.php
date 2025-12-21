<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Satuan;
use App\Models\Product;
use App\Models\DetailObatMasuk;
use App\Models\DetailObatKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'category',
            'satuan',
            'detail_obat_masuk',
            'detail_obat_keluar'
        ])->paginate(7);

        $notifications = $this->getNotifications();

        foreach ($products as $p) {

            // TOTAL MASUK (VALID)
            $totalMasuk = $p->detail_obat_masuk
                ->whereNotNull('obat_masuk_id') // pastikan relasi valid
                ->sum('Jumlah');

            // TOTAL KELUAR
            $totalKeluar = $p->detail_obat_keluar->sum('Jumlah');

            // STOK SEKARANG
            $stok = $totalMasuk - $totalKeluar;

            // cegah stok minus (penting!)
            $p->stokSekarang = $stok > 0 ? $stok : 0;
        }

        return view('pages.products.index', compact('products', 'notifications'));
    }

    public function create() {
        $categories = Category::all();
        $satuans = Satuan::all();

        return view('pages.products.create', compact('categories', 'satuans'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "name" => "required",
            "category_id" => "required",
            "satuan_id" => "required",
        ]);

        // AUTO SKU
        $lastProduct = Product::orderBy('id', 'DESC')->first();
        $nextNumber = $lastProduct ? $lastProduct->id + 1 : 1;

        $sku = 'O' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $validated['sku'] = $sku;
        $validated['stock'] = 0;

        Product::create($validated);

        return redirect('/products')->with('success', 'Data Obat berhasil ditambahkan!');
    }

    public function edit($id) {
        $categories = Category::all();
        $satuans = Satuan::all();
        $product = Product::findOrFail($id);

        return view('pages.products.edit', compact('product', 'categories', 'satuans'));
    }

    public function show($id)
    {
        $product = Product::with([
            'detail_obat_masuk' => function ($q) {
                $q->orderBy('Tanggal_Kadaluwarsa', 'ASC');
            },
            'detail_obat_keluar',
            'category',
            'satuan'
        ])->findOrFail($id);

        // STOK SAAT INI (SUMBER KEBENARAN)
        $stokSekarang = $product->stock;

        // HARGA BELI TERAKHIR (dari histori obat masuk terakhir)
        $latestBatch = $product->detail_obat_masuk->last();
        $hargaBeli = $latestBatch->Harga_Beli ?? 0;

        // HISTORI BATCH (SEMUA OBAT MASUK)
        $batchHistories = $product->detail_obat_masuk;

        return view('pages.products.show', compact(
            'product',
            'batchHistories',
            'hargaBeli',
            'stokSekarang'
        ));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            "name" => "required",
            "sku" => "required|unique:products,sku,".$id,
            "category_id" => "required",
            "satuan_id" => "required",
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect('/products')->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/products')->with('success', 'Data obat berhasil dihapus.');
    }

    private function getNotifications()
    {
        $expired = Product::whereHas('detail_obat_masuk', function ($q) {
            $q->whereDate('Tanggal_Kadaluwarsa', '<', now());
        })->get();

        $stockOut = Product::with(['detail_obat_masuk', 'detail_obat_keluar'])
            ->get()
            ->filter(function ($product) {
                $masuk = $product->detail_obat_masuk->sum('Jumlah');
                $keluar = $product->detail_obat_keluar->sum('Jumlah');
                return ($masuk - $keluar) <= 0;
            });

        return [
            'expired' => $expired,
            'stockOut' => $stockOut,
        ];
    }
}
