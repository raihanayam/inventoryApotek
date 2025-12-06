<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Models\DetailObatMasuk;
use App\Models\DetailObatKeluar;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {

            // Obat expired
            $expired = Product::whereHas('detail_obat_masuk', function ($q) {
                $q->whereDate('Tanggal_Kadaluwarsa', '<', now());
            })->get();

            // Obat stok habis
            $stockOut = Product::with(['detail_obat_masuk', 'detail_obat_keluar'])
                ->get()
                ->filter(function ($product) {
                    $masuk = $product->detail_obat_masuk->sum('Jumlah');
                    $keluar = $product->detail_obat_keluar->sum('Jumlah');
                    return ($masuk - $keluar) <= 0;
                });

            // Kirim ke semua view
            $view->with('notifications', [
                'expired' => $expired,
                'stockOut' => $stockOut,
            ]);
        });
    }
}
