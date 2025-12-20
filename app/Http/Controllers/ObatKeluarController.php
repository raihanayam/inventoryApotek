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
            'detail_obat_keluar.product.satuan'
        ])
        ->orderBy('Tanggal_Keluar', 'ASC')
        ->paginate(7);

        return view('pages.ObatKeluar.index', compact('obat_keluars'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        $user = Auth::user();

        return view('pages.ObatKeluar.create', compact('user', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Jenis_Keluar'      => 'required|string',
            'Tanggal_Keluar'    => 'nullable|date',
            'product_id'        => 'required|array|min:1',
            'product_id.*'      => 'required|exists:products,id',
            'Jumlah'            => 'required|array',
            'Jumlah.*'          => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $obat_keluar = ObatKeluar::create([
                'Id_User'        => Auth::id(),
                'Tanggal_Keluar' => $request->Tanggal_Keluar ?? now(),
                'Jenis_Keluar'   => $request->Jenis_Keluar,
            ]);

            $obat_keluar->Id_Keluar = 'K' . str_pad($obat_keluar->id, 3, '0', STR_PAD_LEFT);
            $obat_keluar->save();

            foreach ($request->product_id as $i => $productId) {

                $jumlahKeluar = $request->Jumlah[$i];
                $product = Product::findOrFail($productId);

                /** QUERY BATCH (FEFO) */
                $batchQuery = $product->detail_obat_masuk()
                    ->where('Jumlah', '>', 0);

                // KHUSUS KADALUARSA → AMBIL YANG SUDAH EXPIRED SAJA
                if ($request->Jenis_Keluar === 'Kadaluarsa') {
                    $batchQuery->whereDate('Tanggal_Kadaluwarsa', '<', now());
                }

                $batches = $batchQuery
                    ->orderBy('Tanggal_Kadaluwarsa', 'ASC')
                    ->get();

                /** VALIDASI KADALUARSA */
                if ($request->Jenis_Keluar === 'Kadaluarsa' && $batches->isEmpty()) {
                    throw ValidationException::withMessages([
                        'Jenis_Keluar' => 'Tidak ada stok obat yang sudah kadaluarsa.'
                    ]);
                }

                /** HITUNG TOTAL STOK VALID */
                $stokValid = $batches->sum('Jumlah');
                if ($jumlahKeluar > $stokValid) {
                    throw ValidationException::withMessages([
                        'Jumlah' => "Stok {$product->name} tidak mencukupi."
                    ]);
                }

                /** FEFO PENGURANGAN BATCH */
                $sisa = $jumlahKeluar;

                foreach ($batches as $batch) {
                    if ($sisa <= 0) break;

                    if ($batch->Jumlah <= $sisa) {
                        $sisa -= $batch->Jumlah;
                        $batch->Jumlah = 0;
                    } else {
                        $batch->Jumlah -= $sisa;
                        $sisa = 0;
                    }

                    $batch->save();
                }

                /** SIMPAN DETAIL KELUAR */
                $detail = DetailObatKeluar::create([
                    'obat_keluar_id' => $obat_keluar->id,
                    'product_id'     => $productId,
                    'Jumlah'         => $jumlahKeluar,
                ]);

                $detail->Id_Detail_Keluar = 'DK' . str_pad($detail->id, 3, '0', STR_PAD_LEFT);
                $detail->save();

                /** UPDATE STOK PRODUK (REAL) */
                $product->stock -= $jumlahKeluar;

                if ($product->stock < 0) {
                    $product->stock = 0;
                }

                $product->save();
            }
        });

        return redirect('/keluar')->with('success', 'Data obat keluar berhasil disimpan.');
    }

    public function show($id)
    {
        $obat_keluar = ObatKeluar::with([
            'user',
            'detail_obat_keluar.product.satuan'
        ])->findOrFail($id);

        return view('pages.ObatKeluar.show', compact('obat_keluar'));
    }

    public function delete($id)
    {
        $obat_keluar = ObatKeluar::with('detail_obat_keluar')->findOrFail($id);

        // NOTE: untuk TA → stok dikembalikan tanpa batch asal
        foreach ($obat_keluar->detail_obat_keluar as $detail) {
            $product = Product::find($detail->product_id);
            if ($product) {
                $product->stock += $detail->Jumlah;
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
        $end_date   = $request->end_date;

        if (($start_date && !$end_date) || (!$start_date && $end_date)) {
            return back()->with('error', 'Harap isi tanggal awal dan tanggal akhir.');
        }

        $obatKeluars = ObatKeluar::with([
            'user',
            'detail_obat_keluar',
            'detail_obat_keluar.product.satuan'
        ])
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('Tanggal_Keluar', [$start_date, $end_date]);
            })
            ->orderBy('Tanggal_Keluar', 'ASC')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.obatKeluar', [
            'obatKeluars' => $obatKeluars,
            'start_date' => $start_date,
            'end_date' => $end_date
        ])->setPaper('A4', 'portrait');

        $filename = ($start_date && $end_date)
            ? "Laporan_Obat_Keluar_{$start_date}_sd_{$end_date}.pdf"
            : "Laporan_Obat_Keluar_Semua.pdf";

        return $pdf->download($filename);
    }
}
