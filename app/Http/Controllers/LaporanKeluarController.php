<?php

namespace App\Http\Controllers;

use App\Models\ObatKeluar;
use App\Models\DetailObatKeluar;
use Illuminate\Http\Request;

class LaporanKeluarController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan; // format: 2025-01

        $obat_keluars = ObatKeluar::with(['user', 'detail_obat_keluar.product.satuan'])
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereYear('Tanggal_Keluar', substr($bulan, 0, 4))
                    ->whereMonth('Tanggal_Keluar', substr($bulan, 5, 2));
            })
            ->orderBy('created_at', 'ASC')
            ->paginate(7)
            ->appends(['bulan' => $bulan]); // agar pagination tetap bawa filter

        // ========== GRAFIK ==========
        $currentYear = date('Y');

        $chartRaw = DetailObatKeluar::join('obat_keluars', 'detail_obat_keluars.obat_keluar_id', '=', 'obat_keluars.id')
            ->selectRaw("MONTH(obat_keluars.Tanggal_Keluar) AS bulan, SUM(detail_obat_keluars.Jumlah) AS total_keluar")
            ->whereYear('obat_keluars.Tanggal_Keluar', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total_keluar', 'bulan');

        $chart_labels = [];
        $chart_values = [];

        for ($i = 1; $i <= 12; $i++) {
            $chart_labels[] = date('M', mktime(0,0,0,$i,10));
            $chart_values[] = $chartRaw[$i] ?? 0;
        }

        return view('pages.laporanKeluar.index', compact(
            'obat_keluars',
            'chart_labels',
            'chart_values',
            'bulan'
        ));
    }

    public function exportPDF(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // Error jika hanya satu tanggal diisi
        if (($start_date && !$end_date) || (!$start_date && $end_date)) {
            return back()->with('error', 'Harap isi tanggal awal dan tanggal akhir.');
        }

        $obatKeluars = ObatKeluar::with(['user', 'detail_obat_keluar.product.satuan'])
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

        $filename = $start_date && $end_date
            ? "Laporan_Obat_Keluar_{$start_date}_sd_{$end_date}.pdf"
            : "Laporan_Obat_Keluar_Semua.pdf";

        return $pdf->download($filename);
    }
}
