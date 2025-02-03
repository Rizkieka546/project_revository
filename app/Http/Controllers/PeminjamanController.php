<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use App\Models\BarangInventaris;
use App\Models\Siswa;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Mengambil semua data peminjaman beserta relasi siswa dan peminjaman barang
        $peminjaman = Peminjaman::with(['siswa', 'peminjamanBarang.barangInventaris'])->get();
        return view('peminjaman.index', compact('peminjaman'));
    }


    public function create()
    {
        // Mengambil semua data siswa
        $siswa = Siswa::all();

        // Mengambil barang yang belum dipinjam (berstatus 1 pada td_peminjaman_barang)
        $barang = BarangInventaris::whereNotIn('br_kode', function ($query) {
            $query->select('br_kode')->from('td_peminjaman_barang')->where('pdb_sts', 1);
        })->get();

        return view('peminjaman.create', compact('siswa', 'barang'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi data input
            $validated = $request->validate([
                'siswa_id' => 'required|exists:siswa,siswa_id',
                'br_kode' => 'required|exists:tm_barang_inventaris,br_kode',
                'pb_tgl' => 'required|date_format:Y-m-d',
            ]);

            // Ambil data barang yang dipinjam
            $barang = BarangInventaris::findOrFail($request->br_kode);

            // Tentukan tanggal peminjaman dan batas pengembalian
            $tanggalPeminjaman = Carbon::createFromFormat('Y-m-d', $request->pb_tgl);
            $tanggalKembali = $tanggalPeminjaman->addWeek(); // Misalnya, pinjam barang 1 minggu

            DB::beginTransaction();

            // Membuat ID peminjaman dengan format 'PJYYYYMMNNN'
            $tahun = $tanggalPeminjaman->year;
            $bulan = $tanggalPeminjaman->month;

            do {
                // Mendapatkan nomor urut berdasarkan tahun dan bulan
                $noUrut = Peminjaman::whereYear('pb_tgl', $tahun)
                    ->whereMonth('pb_tgl', $bulan)
                    ->max('pb_id'); // Mengambil nilai terbesar dari pb_id
                $noUrut = $noUrut ? (int)substr($noUrut, -3) + 1 : 1; // Menambah nomor urut

                // Membuat ID peminjaman
                $pb_id = 'PJ' . $tahun . str_pad($bulan, 2, '0', STR_PAD_LEFT) . str_pad($noUrut, 3, '0', STR_PAD_LEFT);
            } while (Peminjaman::where('pb_id', $pb_id)->exists()); // Memastikan tidak ada duplikasi pb_id

            // Menyimpan data peminjaman utama
            $peminjaman = new Peminjaman();
            $peminjaman->pb_id = $pb_id;
            $peminjaman->siswa_id = $request->siswa_id;
            $peminjaman->pb_tgl = $tanggalPeminjaman;
            $peminjaman->pb_harus_kembali_tgl = $tanggalKembali;
            $peminjaman->pb_stat = '1'; // Status aktif
            $peminjaman->save();

            // Menyimpan data peminjaman barang terkait
            $pbd_noUrut = PeminjamanBarang::where('pb_id', $pb_id)->count() + 1;
            $pbd_id = $pb_id . str_pad($pbd_noUrut, 3, '0', STR_PAD_LEFT);

            $peminjamanBarang = new PeminjamanBarang();
            $peminjamanBarang->pbd_id = $pbd_id;
            $peminjamanBarang->pb_id = $peminjaman->pb_id;
            $peminjamanBarang->br_kode = $request->br_kode;
            $peminjamanBarang->pdb_tgl = $tanggalPeminjaman;
            $peminjamanBarang->pdb_sts = '1'; // Status aktif
            $peminjamanBarang->save();

            // Commit transaksi jika tidak ada error
            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman barang berhasil dilakukan!');
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
