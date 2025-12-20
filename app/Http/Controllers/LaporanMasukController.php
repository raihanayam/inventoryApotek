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

    public function exportPDF(Request $request)
    {
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        if (($start_date && !$end_date) || (!$start_date && $end_date)) {
            return back()->with('error', 'Harap isi tanggal awal dan akhir.');
        }

        $details = DetailObatMasuk::with([
            'product.satuan',
            'obat_masuk.user'
        ])
        ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
            $q->whereHas('obat_masuk', function ($sub) use ($start_date, $end_date) {
                $sub->whereBetween('Tanggal_Masuk', [$start_date, $end_date]);
            });
        })
        ->orderBy('created_at', 'ASC')
        ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.ObatMasuk', [
            'details' => $details,
            'start_date' => $start_date,
            'end_date' => $end_date
        ])->setPaper('A4', 'portrait');

        return $pdf->download(
            $start_date && $end_date
                ? "Laporan_Obat_Masuk_{$start_date}_sd_{$end_date}.pdf"
                : "Laporan_Obat_Masuk_Semua.pdf"
        );
    }
}
