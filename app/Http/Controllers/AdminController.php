<?php

namespace App\Http\Controllers;

use App\Models\BarangInventaris;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Data untuk statistik
        $jumlahBarang = BarangInventaris::count();
        $jumlahPeminjaman = Peminjaman::count();

        // Grafik transaksi peminjaman bulanan
        $dataGrafik = Peminjaman::selectRaw('MONTH(pb_tgl) as bulan, YEAR(pb_tgl) as tahun, COUNT(*) as jumlah')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'ASC')
            ->orderBy('bulan', 'ASC')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::create($item->tahun, $item->bulan, 1)->format('Y-m') => $item->jumlah];
            });

        // Ambil data untuk 12 bulan terakhir
        $labels = [];
        $formattedData = [];
        $currentDate = Carbon::now();

        for ($i = 11; $i >= 0; $i--) {
            $date = $currentDate->copy()->subMonths($i);
            $formattedMonth = $date->format('Y-m');
            $labels[] = $date->format('M Y'); // Format bulan dalam huruf (contoh: Jan 2024)
            $formattedData[] = $dataGrafik[$formattedMonth] ?? 0;
        }

        // Kirim data ke view
        return view('dashboard.admin', compact('jumlahBarang', 'jumlahPeminjaman', 'labels', 'formattedData'));
    }
}
