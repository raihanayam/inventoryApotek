<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\DetailObatMasuk;
use App\Models\DetailObatKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanStokController extends Controller
{
    public function index()
    {
        // Ambil semua produk
        $products = Product::with(['category', 'satuan'])->paginate(7);

        foreach ($products as $p) {

            // HISTORI (UNTUK LAPORAN)
            $p->masuk = DetailObatMasuk::where('product_id', $p->id)->sum('Jumlah');
            $p->keluar = DetailObatKeluar::where('product_id', $p->id)->sum('Jumlah');

            // STOK REAL (SUMBER KEBENARAN)
            $p->stok_saat_ini = $p->stock;
        }

        // Obat hampir habis
        $obat_hampir_habis = $products->filter(function ($item) {
            return $item->stok_akhir <= 10;
        });

        $currentYear = now()->year;

        $chart_labels = [];
        $chart_values_masuk = [];
        $chart_values_keluar = [];

        for ($month = 1; $month <= 12; $month++) {

            // Label (Jan, Feb, dst)
            $chart_labels[] = \Carbon\Carbon::createFromDate($currentYear, $month, 1)->format('M Y');

            // --- OBAT MASUK ---
            $masuk = DetailObatMasuk::join(
                    'obat_masuks',
                    'detail_obat_masuks.obat_masuk_id',
                    '=',
                    'obat_masuks.id'
                )
                ->whereYear('obat_masuks.Tanggal_Masuk', $currentYear)
                ->whereMonth('obat_masuks.Tanggal_Masuk', $month)
                ->sum('detail_obat_masuks.Jumlah');

            // --- OBAT KELUAR ---
            $keluar = DetailObatKeluar::join(
                    'obat_keluars',
                    'detail_obat_keluars.obat_keluar_id',
                    '=',
                    'obat_keluars.id'
                )
                ->whereYear('obat_keluars.Tanggal_Keluar', $currentYear)
                ->whereMonth('obat_keluars.Tanggal_Keluar', $month)
                ->sum('detail_obat_keluars.Jumlah');

            // Kalau NULL, ganti 0
            $chart_values_masuk[] = $masuk ?: 0;
            $chart_values_keluar[] = $keluar ?: 0;
        }

        return view('pages.laporanStok.index', compact(
            'products',
            'obat_hampir_habis',
            'chart_labels',
            'chart_values_masuk',
            'chart_values_keluar'
        ));
    }

    public function exportPDF()
    {
        $products = Product::with([
            'category',
            'satuan',
            'detail_obat_masuk',
            'detail_obat_keluar'
        ])->get();

        foreach ($products as $p) {

            // TOTAL MASUK
            $p->total_masuk = $p->detail_obat_masuk->sum('Jumlah');

            // TOTAL KELUAR
            $p->total_keluar = $p->detail_obat_keluar->sum('Jumlah');

            // STOK SAAT INI (AMAN, TIDAK MINUS)
            $p->stok_sekarang = max($p->total_masuk - $p->total_keluar, 0);

            // HARGA BELI TERBARU (OBAT MASUK TERAKHIR)
            $latestBatch = $p->detail_obat_masuk
                ->sortByDesc('Tanggal_Masuk')
                ->first();

            $p->harga_beli = $latestBatch->Harga_Beli ?? 0;

            // EXPIRED TERDEKAT (YANG MASIH ADA STOK)
            $expiredBatch = $p->detail_obat_masuk
                ->where('Jumlah', '>', 0)
                ->sortBy('Tanggal_Kadaluwarsa')
                ->first();

            $p->expired_terdekat = $expiredBatch->Tanggal_Kadaluwarsa ?? null;
        }

        $pdf = Pdf::loadView('laporan.Produk', [
            'products' => $products,
        ])->setPaper('A4', 'portrait');

        return $pdf->download("Laporan_Stok_Semua.pdf");
    }
}
