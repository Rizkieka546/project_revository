<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangInventaris;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class LaporanController extends Controller
{
    public function laporanBarang(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query barang berdasarkan tanggal diterima
        $barang = BarangInventaris::when($startDate, function ($query, $startDate) {
            return $query->whereDate('br_tgl_terima', '>=', $startDate);
        })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('br_tgl_terima', '<=', $endDate);
            })
            ->orderBy('br_tgl_terima', 'desc') // Urutkan berdasarkan tanggal diterima
            ->get();

        return view('laporan.barang', compact('barang', 'startDate', 'endDate'));
    }

    public function laporanPengembalian(Request $request)
    {
        // Ambil input tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query data pengembalian dengan filter tanggal dan load relasi
        $pengembalian = Pengembalian::with(['peminjaman.siswa', 'peminjaman.peminjamanBarang.barangInventaris'])
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('kembali_tgl', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('kembali_tgl', '<=', $endDate);
            })
            ->orderBy('kembali_tgl', 'desc')
            ->get();

        // Kirim data ke view
        return view('laporan.pengembalian', compact('pengembalian', 'startDate', 'endDate'));
    }

    public function laporanStatusBarang(Request $request)
    {
        // Ambil input status dari request
        $status = $request->input('status');

        // Query data barang dengan filter status
        $barang = BarangInventaris::when($status, function ($query, $status) {
            return $query->where('br_status', $status);
        })
            ->get();

        // Kirim data ke view
        return view('laporan.status-barang', compact('barang', 'status'));
    }
}
