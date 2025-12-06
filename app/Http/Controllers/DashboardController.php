<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Satuan;
use App\Models\ObatKeluar;
use App\Models\ObatMasuk;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $satuanCount = Satuan::count();
        $obat_masukCount = ObatMasuk::count();
        $obat_keluarCount = ObatKeluar::count();
        $userCount = User::count();

        return view('pages.dashboard.admin', compact('productCount', 'categoryCount', 'satuanCount', 'obat_masukCount', 'obat_keluarCount', 'userCount'));
    }
}
