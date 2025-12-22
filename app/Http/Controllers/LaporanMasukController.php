<?php

namespace App\Http\Controllers;

use App\Models\DetailObatMasuk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanMasukController extends Controller
{
    public function index()
    {
        $details = DetailObatMasuk::join(
                'obat_masuks',
                'detail_obat_masuks.obat_masuk_id',
                '=',
                'obat_masuks.id'
            )
            ->with([
                'product.satuan',
                'obat_masuk.user'
            ])
            ->orderBy('obat_masuks.Tanggal_Masuk', 'asc')
            ->select('detail_obat_masuks.*')
            ->paginate(7);

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
        $details = DetailObatMasuk::join(
                'obat_masuks',
                'detail_obat_masuks.obat_masuk_id',
                '=',
                'obat_masuks.id'
            )
            ->with([
                'product.satuan',
                'obat_masuk.user'
            ])
            ->orderBy('obat_masuks.Tanggal_Masuk', 'asc')
            ->select('detail_obat_masuks.*')
            ->get();

        $pdf = Pdf::loadView('laporan.obatMasuk', compact('details'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Obat_Masuk.pdf');
    }
}
