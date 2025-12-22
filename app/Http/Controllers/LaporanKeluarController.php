<?php

namespace App\Http\Controllers;

use App\Models\DetailObatKeluar;
use App\Models\ObatKeluar;
use Barryvdh\DomPDF\Facade\PDF as PDF;

class LaporanKeluarController extends Controller
{
    public function index()
    {
        $details = DetailObatKeluar::with([
                'product.satuan',
                'obat_keluar.user'
            ])
            ->whereHas('obat_keluar')
            ->orderBy(
                ObatKeluar::select('Tanggal_Keluar')
                    ->whereColumn('obat_keluars.id', 'detail_obat_keluars.obat_keluar_id')
            )
            ->paginate(7);

        // ===== GRAFIK =====
        $currentYear = date('Y');

        $chartRaw = DetailObatKeluar::join(
                'obat_keluars',
                'detail_obat_keluars.obat_keluar_id',
                '=',
                'obat_keluars.id'
            )
            ->whereYear('obat_keluars.Tanggal_Keluar', $currentYear)
            ->selectRaw('MONTH(obat_keluars.Tanggal_Keluar) AS bulan, SUM(detail_obat_keluars.Jumlah) AS total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $chart_labels = [];
        $chart_values = [];

        for ($i = 1; $i <= 12; $i++) {
            $chart_labels[] = date('M', mktime(0, 0, 0, $i, 1));
            $chart_values[] = $chartRaw[$i] ?? 0;
        }

        return view('pages.laporanKeluar.index', compact(
            'details',
            'chart_labels',
            'chart_values'
        ));
    }

    public function exportPDF()
    {
        // 🔒 Proteksi hosting
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        $details = DetailObatKeluar::with([
                'product.satuan',
                'obat_keluar.user'
            ])
            ->whereHas('obat_keluar')
            ->orderBy(
                ObatKeluar::select('Tanggal_Keluar')
                    ->whereColumn('obat_keluars.id', 'detail_obat_keluars.obat_keluar_id')
            )
            ->get();

        $pdf = PDF::loadView('laporan.ObatKeluar', compact('details'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'dejavu sans',
            ]);

        return $pdf->download('Laporan_Obat_Keluar.pdf');
    }
}
