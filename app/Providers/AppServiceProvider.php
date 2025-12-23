<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
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

            // ============================
            // STOK MENIPIS
            // ============================
            $lowStock = Product::where('stock', '>', 0)
                ->where('stock', '<=', 5)
                ->whereHas('satuan', function ($q) {
                    $q->whereNotIn('name', ['box', 'pack']);
                })
                ->get();

            // ============================
            // STOK HABIS
            // ============================
            $stockOut = Product::where('stock', '<=', 0)->get();

//                 dd([
//     'expired' => $expired,
//     'stockOut' => $stockOut,
//     'lowStock' => $lowStock,
// ]);


            $view->with('notifications', [
                'lowStock' => $lowStock,
                'stockOut' => $stockOut,
            ]);
        });
    }
}
