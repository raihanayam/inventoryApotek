<?php

namespace App\Http\Controllers;

use App\Models\ObatKeluar;
use App\Models\DetailObatKeluar;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ObatKeluarController extends Controller
{
    public function index()
    {
        $obat_keluars = ObatKeluar::with([
                                'user',
                                'detail_obat_keluar',
                                'detail_obat_keluar.product',
                                'detail_obat_keluar.satuan'
                            ])
                            ->orderBy('Tanggal_Keluar', 'ASC')
                            ->paginate(7);

        return view('pages.ObatKeluar.index', compact('obat_keluars'));
    }

    public function create()
    {
        $products = Product::all();
        $user = Auth::user();

        return view('pages.ObatKeluar.create', compact('user', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Jenis_Keluar' => 'required|string',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'Jumlah' => 'required|array',
            'Jumlah.*' => 'required|numeric|min:1',
        ]);

        // validasi stok
        foreach ($request->product_id as $index => $productId) {

            $product = Product::find($productId);
            $jumlah = $request->Jumlah[$index];

            // Untuk jenis keluar biasa
            if ($request->Jenis_Keluar !== "Kadaluarsa") {

                $totalStok = $product->detail_obat_masuk()->sum('Jumlah');

                if ($jumlah > $totalStok) {
                    throw ValidationException::withMessages([
                        'Jumlah' => "Stok untuk {$product->name} tidak mencukupi! (Stok tersedia: {$totalStok})"
                    ]);
                }
            }
        }

        DB::transaction(function () use ($request) {

            // Create transaksi utama
            $obat_keluar = ObatKeluar::create([
                'Id_User' => Auth::id(),
                'Tanggal_Keluar' => $request->Tanggal_Keluar ?? now(),
                'Jenis_Keluar' => $request->Jenis_Keluar,
            ]);

            // Generate ID Keluar
            $obat_keluar->Id_Keluar = 'K' . str_pad($obat_keluar->id, 3, '0', STR_PAD_LEFT);
            $obat_keluar->save();

            // Iterasi detail
            foreach ($request->product_id as $index => $productId) {

                $jumlah = $request->Jumlah[$index];
                $product = Product::find($productId);

                // Jika jenis keluar KADALUARSA → auto ambil batch expired
                if ($request->Jenis_Keluar == "Kadaluarsa") {

                    $expiredBatch = $product->detail_obat_masuk()
                        ->where('Tanggal_Kadaluwarsa', '<', now())
                        ->orderBy('Tanggal_Kadaluwarsa', 'asc')
                        ->first();

                    if ($expiredBatch) {

                        $jumlah = $expiredBatch->Jumlah;

                        // Hapus batch kadaluarsa
                        $expiredBatch->delete();
                    }
                }

                // Insert detail
                $detail = DetailObatKeluar::create([
                    'obat_keluar_id' => $obat_keluar->id,
                    'product_id'     => $productId,
                    'Jumlah'         => $jumlah,
                ]);

                // Generate ID detail
                $detail->Id_Detail_Keluar = 'DK' . str_pad($detail->id, 3, '0', STR_PAD_LEFT);
                $detail->save();

                // Hapus batch yang sudah habis
                $product->detail_obat_masuk()->where('Jumlah', 0)->delete();

                // Hitung total stok berdasarkan batch
                $totalStok = $product->detail_obat_masuk()->sum('Jumlah');

                // Update stok di tabel products
                $product->stock = $totalStok;
                $product->save();
            }
        });

        return redirect('/keluar')->with('success', 'Data obat keluar berhasil disimpan.');
    }

    public function show($id)
    {
        $obat_keluar = ObatKeluar::with(['user', 'detail_obat_keluar.product'])
                        ->findOrFail($id);

        return view('pages.ObatKeluar.show', compact('obat_keluar'));
    }

    public function delete($id)
    {
        $obat_keluar = ObatKeluar::with('detail_obat_keluar')->findOrFail($id);

        // Kembalikan stok
        foreach ($obat_keluar->detail_obat_keluar as $detail) {
        $product = Product::find($detail->product_id);

        if ($product) {
            $product->stock += $detail->jumlah; 
            $product->save();
        }
    }

        $obat_keluar->detail_obat_keluar()->delete();
        $obat_keluar->delete();

        return redirect('/keluar')->with('success', 'Data obat keluar berhasil dihapus.');
    }
    
    public function exportPDF(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $bulan = $request->bulan;

        if (($start_date && !$end_date) || (!$start_date && $end_date)) {
            return back()->with('error', 'Harap isi tanggal awal dan tanggal akhir.');
        }

        $obatKeluars = ObatKeluar::with([
                'user',
                'detail_obat_keluar',
                'detail_obat_keluar.product',
                'detail_obat_keluar.satuan'
            ])
            ->when($bulan, function ($q) use ($bulan) {
                $q->whereYear('Tanggal_Keluar', substr($bulan, 0, 4))
                ->whereMonth('Tanggal_Keluar', substr($bulan, 5, 2));
            })
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('Tanggal_Keluar', [$start_date, $end_date]);
            })
            ->orderBy('Tanggal_Keluar', 'ASC')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.obatKeluar', [
            'obatKeluars' => $obatKeluars,
            'bulan' => $bulan,
            'start_date' => $start_date,
            'end_date' => $end_date
        ])->setPaper('A4', 'portrait');

        $filename = $bulan
            ? "Laporan_Obat_Keluar_{$bulan}.pdf"
            : ($start_date && $end_date
                ? "Laporan_Obat_Keluar_{$start_date}_sd_{$end_date}.pdf"
                : "Laporan_Obat_Keluar_Semua.pdf");

        return $pdf->download($filename);
    }
}
