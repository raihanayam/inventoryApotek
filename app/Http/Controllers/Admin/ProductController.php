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
    public function index() {
        $products = Product::with(['category', 'satuan', 'detail_obat_masuk', 'detail_obat_keluar'])->paginate(7);
        $notifications = $this->getNotifications();

        // hitung stok tiap produk
        foreach ($products as $p) {
            $totalMasuk = $p->detail_obat_masuk->sum('Jumlah');
            $totalKeluar = $p->detail_obat_keluar->sum('Jumlah');
            $p->stokSekarang = $totalMasuk - $totalKeluar;
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

    public function show($id){
        $product = Product::findOrFail($id);

        // Harga beli terakhir
        $latestPurchase = $product->detail_obat_masuk()->latest()->first();
        $hargaBeli = $latestPurchase->Harga_Beli ?? 0;

        // Harga jual otomatis 10%
        $hargaJual = $hargaBeli * 1.10;

        // Hitung stok dinamis
        $totalMasuk = $product->detail_obat_masuk->sum('Jumlah');
        $totalKeluar = $product->detail_obat_keluar->sum('Jumlah');
        $stokSekarang = $totalMasuk - $totalKeluar;

        return view('pages.products.show', compact(
            'product',
            'hargaJual',
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

    public function exportPDF()
    {
        $products = Product::with(['category', 'satuan'])->get();

        foreach ($products as $p) {
            $p->total_masuk = DetailObatMasuk::where('product_id', $p->id)->sum('Jumlah');
            $p->total_keluar = DetailObatKeluar::where('product_id', $p->id)->sum('Jumlah');
            $p->stok_sekarang = $p->total_masuk - $p->total_keluar;
        }

        $pdf = Pdf::loadView('laporan.Produk', [
            'products' => $products,
        ])->setPaper('A4', 'portrait');

        return $pdf->download("Laporan_Stok_Semua.pdf");
    }
}
