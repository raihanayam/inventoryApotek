<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk;
use App\Models\DetailObatMasuk;
use Illuminate\Http\Request;

class LaporanMasukController extends Controller {
    public function index(Request $request) 
    {
        $bulan = $request->bulan; // format: 2025-02

        $query = ObatMasuk::with(['user', 'detail_obat_masuk.product.satuan']);

        // Jika user memilih bulan
        if ($bulan) {
            $bulanNumber = substr($bulan, 5, 2);
            $tahunNumber = substr($bulan, 0, 4);

            $query->whereMonth('Tanggal_Masuk', $bulanNumber)
                ->whereYear('Tanggal_Masuk', $tahunNumber);
        }

        $obat_masuks = $query->orderBy('created_at', 'ASC')->paginate(7);

        // ---- Grafik tetap sama ----
        $currentYear = date('Y');

        $chartRaw = DetailObatMasuk::join('obat_masuks', 'detail_obat_masuks.obat_masuk_id', '=', 'obat_masuks.id')
            ->selectRaw("MONTH(obat_masuks.Tanggal_Masuk) AS bulan, SUM(detail_obat_masuks.Jumlah) AS total_masuk")
            ->whereYear('obat_masuks.Tanggal_Masuk', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total_masuk', 'bulan');


        $chart_labels = [];
        $chart_values = [];

        for ($i = 1; $i <= 12; $i++) {
            $chart_labels[] = date('M', mktime(0,0,0,$i,10));
            $chart_values[] = $chartRaw[$i] ?? 0;
        }

        return view('pages.laporanMasuk.index', compact(
            'obat_masuks',
            'chart_labels',
            'chart_values'
        ));
    }

    public function exportPDF(Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // Cek jika salah satu tanggal kosong
        if (($start_date && !$end_date) || (!$start_date && $end_date)) {
            return back()->with('error', 'Harap isi tanggal awal dan akhir.');
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

        $filename = $start_date && $end_date
            ? "Laporan_Obat_Masuk_{$start_date}_sd_{$end_date}.pdf"
            : "Laporan_Obat_Masuk_Semua.pdf";

        return $pdf->download($filename);
    }
}
