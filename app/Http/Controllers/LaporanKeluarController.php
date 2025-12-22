<?php

namespace App\Http\Controllers;

use App\Models\DetailObatKeluar;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeluarController extends Controller
{
    public function index()
    {
        $details = DetailObatKeluar::join(
                'obat_keluars',
                'detail_obat_keluars.obat_keluar_id',
                '=',
                'obat_keluars.id'
            )
            ->with([
                'product.satuan',
                'obat_keluar.user'
            ])
            ->orderBy('obat_keluars.Tanggal_Keluar', 'asc')
            ->select('detail_obat_keluars.*')
            ->paginate(7);

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
        $details = DetailObatKeluar::join(
                'obat_keluars',
                'detail_obat_keluars.obat_keluar_id',
                '=',
                'obat_keluars.id'
            )
            ->with([
                'product.satuan',
                'obat_keluar.user'
            ])
            ->orderBy('obat_keluars.Tanggal_Keluar', 'asc')
            ->select('detail_obat_keluars.*')
            ->get();

        $pdf = Pdf::loadView('laporan.obatKeluar', compact('details'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Obat_Keluar.pdf');
    }
}
