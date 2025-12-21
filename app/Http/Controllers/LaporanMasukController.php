<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk;
use App\Models\DetailObatMasuk;
use Illuminate\Http\Request;

class LaporanMasukController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan; // format: YYYY-MM

        /** =========================
         *  DATA LAPORAN (DETAIL BASED)
         *  ========================= */
        $detailQuery = DetailObatMasuk::with([
            'product.satuan',
            'obat_masuk.user'
        ]);

        if ($bulan) {
            $detailQuery->whereHas('obat_masuk', function ($q) use ($bulan) {
                $q->whereMonth('Tanggal_Masuk', substr($bulan, 5, 2))
                  ->whereYear('Tanggal_Masuk', substr($bulan, 0, 4));
            });
        }

        $details = $detailQuery
            ->orderBy(
                ObatMasuk::select('Tanggal_Masuk')
                    ->whereColumn('obat_masuks.id', 'detail_obat_masuks.obat_masuk_id')
            )
            ->paginate(7);

        /** =========================
         *  DATA GRAFIK (PER BULAN)
         *  ========================= */
        $currentYear = date('Y');

        $chartRaw = DetailObatMasuk::join(
                'obat_masuks',
                'detail_obat_masuks.obat_masuk_id',
                '=',
                'obat_masuks.id'
            )
            ->selectRaw('MONTH(obat_masuks.Tanggal_Masuk) AS bulan, SUM(detail_obat_masuks.Jumlah) AS total')
            ->whereYear('obat_masuks.Tanggal_Masuk', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $chart_labels = [];
        $chart_values = [];

        for ($i = 1; $i <= 12; $i++) {
            $chart_labels[] = date('M', mktime(0, 0, 0, $i, 1));
            $chart_values[] = $chartRaw[$i] ?? 0;
        }

        return view('pages.laporanMasuk.index', compact(
            'details',
            'chart_labels',
            'chart_values'
        ));
    }

    public function exportPDF()
    {
        $details = DetailObatMasuk::with([
            'product.satuan',
            'obat_masuk.user'
        ])
        ->orderBy(
            ObatMasuk::select('Tanggal_Masuk')
                ->whereColumn('obat_masuks.id', 'detail_obat_masuks.obat_masuk_id')
        )
        ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.obatMasuk', [
            'details' => $details
        ])->setPaper('A4', 'portrait');

        return $pdf->download("Laporan_Obat_Masuk.pdf");
    }
}
