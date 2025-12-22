<?php

namespace App\Http\Controllers;

use App\Models\DetailObatMasuk;
use App\Models\ObatMasuk;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanMasukController extends Controller
{
    public function index()
    {
        $details = DetailObatMasuk::with([
                'product.satuan',
                'obat_masuk.user'
            ])
            ->whereHas('obat_masuk')
            ->orderBy(
                ObatMasuk::select('Tanggal_Masuk')
                    ->whereColumn('obat_masuks.id', 'detail_obat_masuks.obat_masuk_id')
            )
            ->paginate(7);

        // ===== GRAFIK =====
        $currentYear = date('Y');

        $chartRaw = DetailObatMasuk::join(
                'obat_masuks',
                'detail_obat_masuks.obat_masuk_id',
                '=',
                'obat_masuks.id'
            )
            ->whereYear('obat_masuks.Tanggal_Masuk', $currentYear)
            ->selectRaw('MONTH(obat_masuks.Tanggal_Masuk) AS bulan, SUM(detail_obat_masuks.Jumlah) AS total')
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
        try {
            ini_set('max_execution_time', 300);
            ini_set('memory_limit', '512M');

            $details = DetailObatMasuk::with(['product.satuan','obat_masuk.user'])
                ->whereHas('obat_masuk')
                ->get();

            $pdf = Pdf::loadView('laporan.ObatMasuk', compact('details'))
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => false,
                    'defaultFont' => 'DejaVu Sans',
                ]);

            return $pdf->download('Laporan_Obat_Masuk.pdf');
        } catch (\Throwable $e) {
            // untuk debugging (sementara)
            return response()->json([
                'error' => $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}
