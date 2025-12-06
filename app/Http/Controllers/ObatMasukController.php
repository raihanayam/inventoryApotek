<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\ObatMasuk;
use App\Models\DetailObatMasuk;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ObatMasukController extends Controller
{
    public function index() {
        $obat_masuks = ObatMasuk::with(['user', 'detail_obat_masuk.product.satuan'])
                            ->orderBy('created_at', 'ASC')
                            ->paginate(7);

        return view('pages.ObatMasuk.index', compact('obat_masuks'));
    }

    public function create()
    {
        return view('pages.ObatMasuk.create', [
            'products' => Product::all(),
            'user' => Auth::user()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_User' => 'required',
            'Tanggal_Masuk' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.Jumlah' => 'required|integer|min:1',
            'items.*.Harga_Beli' => 'required|numeric|min:0',
            'items.*.Tanggal_Kadaluwarsa' => 'required|date'
        ]);

        DB::beginTransaction();

        try {

            // 1. Simpan transaksi utama
            $obat_masuks = ObatMasuk::create([
                'Id_User' => $request->Id_User,
                'Tanggal_Masuk' => $request->Tanggal_Masuk,
                'Total' => collect($request->items)->sum('Jumlah'),
            ]);

            // 2. Generate ID Masuk (contoh: M001)
            $obat_masuks->Id_Masuk = 'M' . str_pad($obat_masuks->id, 3, '0', STR_PAD_LEFT);
            $obat_masuks->save();

            // 3. Simpan detail
            foreach ($request->items as $item) {

                $detail = DetailObatMasuk::create([
                    'obat_masuk_id' => $obat_masuks->id,
                    'product_id' => $item['product_id'],
                    'Jumlah' => $item['Jumlah'],
                    'Harga_Beli' => $item['Harga_Beli'],
                    'Tanggal_Kadaluwarsa' => $item['Tanggal_Kadaluwarsa'],
                ]);

                // 4. Generate ID Detail Masuk (contoh: DM001)
                $detail->Id_Detail_Masuk = 'DM' . str_pad($detail->id, 3, '0', STR_PAD_LEFT);
                $detail->save();

                // 5. Update stok produk
                $product = Product::find($item['product_id']);
                $product->stock += $item['Jumlah'];
                $product->save();
            }

            DB::commit();

            return redirect('/masuk')->with('success', 'Obat masuk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $obat_masuks = ObatMasuk::with('detail_obat_masuk.product')->findOrFail($id);
        return view('pages.ObatMasuk.show', compact('obat_masuks'));
    }

    public function delete($id)
    {
        $obat_masuks = ObatMasuk::findOrFail($id);

        // kembalikan stok
        foreach ($obat_masuks->detail_obat_masuk as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock -= $item->Jumlah;
                $product->save();
            }
        }

        $obat_masuks->detail_obat_masuk()->delete();

        return redirect('/masuk')->with('success', 'Data obat masuk berhasil dihapus.');
    }

    public function exportPDF(Request $request) {
        $bulan = $request->bulan;

        // Jika bulan dipilih → otomatis set awal & akhir bulan
        if ($bulan) {
            $start_date = $bulan . '-01';
            $end_date = date("Y-m-t", strtotime($start_date)); // t = last day of month
        } else {
            $start_date = null;
            $end_date = null;
        }

        $obat_masuks = ObatMasuk::with('detail_obat_masuk.product')
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('Tanggal_Masuk', [$start_date, $end_date]);
            })
            ->orderBy('Tanggal_Masuk', 'ASC')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.ObatMasuk', [
            'obat_masuks' => $obat_masuks,
            'start_date' => $start_date,
            'end_date' => $end_date
        ])->setPaper('A4', 'portrait');

        $filename = $bulan
            ? "Laporan_Obat_Masuk_{$bulan}.pdf"
            : "Laporan_Obat_Masuk_Semua.pdf";

        return $pdf->download($filename);
    }
}
