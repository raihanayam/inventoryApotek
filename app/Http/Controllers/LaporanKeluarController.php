<?php

namespace App\Http\Controllers;

use App\Models\ObatKeluar;
use App\Models\DetailObatKeluar;
use Illuminate\Http\Request;

class LaporanKeluarController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan; // format: YYYY-MM

        // =======================
        // DATA TABEL (DETAIL)
        // =======================
        $detailQuery = DetailObatKeluar::with([
            'product.satuan',
            'obat_keluar.user'
        ]);

        if ($bulan) {
            $detailQuery->whereHas('obat_keluar', function ($q) use ($bulan) {
                $q->whereYear('Tanggal_Keluar', substr($bulan, 0, 4))
                  ->whereMonth('Tanggal_Keluar', substr($bulan, 5, 2));
            });
        }

        $details = $detailQuery
            ->orderBy(
                \App\Models\ObatKeluar::select('Tanggal_Keluar')
                    ->whereColumn('obat_keluars.id', 'detail_obat_keluars.obat_keluar_id')
            )
            ->paginate(7)
            ->appends(['bulan' => $bulan]);

        // =======================
        // DATA GRAFIK
        // =======================
        $currentYear = date('Y');

        $chartRaw = DetailObatKeluar::join(
                'obat_keluars',
                'detail_obat_keluars.obat_keluar_id',
                '=',
                'obat_keluars.id'
            )
            ->selectRaw('MONTH(obat_keluars.Tanggal_Keluar) AS bulan, SUM(detail_obat_keluars.Jumlah) AS total')
            ->whereYear('obat_keluars.Tanggal_Keluar', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $chart_labels = [];
        $chart_values = [];

        for ($i = 1; $i <= 12; $i++) {
            $chart_labels[] = date('M', mktime(0, 0, 0, $i, 10));
            $chart_values[] = $chartRaw[$i] ?? 0;
        }

        return view('pages.laporanKeluar.index', compact(
            'details',
            'chart_labels',
            'chart_values',
            'bulan'
        ));
    }

    public function exportPDF()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $details = DetailObatKeluar::with([
            'product.satuan',
            'obat_keluar.user'
        ])
        ->orderBy(
            ObatKeluar::select('Tanggal_Keluar')
                ->whereColumn('obat_keluars.id', 'detail_obat_keluars.obat_keluar_id')
        )
        ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.obatKeluar', [
            'details' => $details
        ])->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Obat_Keluar.pdf');
    }
}
