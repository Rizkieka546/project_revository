<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use App\Models\BarangInventaris;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * Menampilkan daftar barang yang sedang dipinjam
     */
    public function index()
    {
        // Ambil semua peminjaman yang statusnya 'Dipinjam' (pb_stat == 1)
        $peminjaman = Peminjaman::where('pb_stat', 1)
            ->with(['siswa', 'peminjamanBarang.barangInventaris'])
            ->get();

        return view('pengembalian.index', compact('peminjaman'));
    }

    /**
     * Proses pengembalian barang
     */
    public function kembalikan(Request $request, $pb_id, $br_kode)
    {
        DB::beginTransaction();

        try {
            // Cari peminjaman barang berdasarkan pb_id dan br_kode
            $peminjamanBarang = PeminjamanBarang::where('pb_id', $pb_id)
                ->where('br_kode', $br_kode)
                ->first();

            if (!$peminjamanBarang) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            // Ubah status peminjaman barang menjadi dikembalikan (misal 0 = selesai)
            $peminjamanBarang->update([
                'pdb_sts' => 0, // 0 = Barang sudah dikembalikan
            ]);

            // Cek apakah semua barang dalam peminjaman ini sudah dikembalikan
            $jumlahBarangBelumDikembalikan = PeminjamanBarang::where('pb_id', $pb_id)
                ->where('pdb_sts', 1) // 1 = Masih dipinjam
                ->count();

            // Jika semua barang dalam peminjaman ini sudah dikembalikan, ubah status peminjaman
            if ($jumlahBarangBelumDikembalikan == 0) {
                Peminjaman::where('pb_id', $pb_id)->update(['pb_stat' => 0]); // 0 = Selesai
            }

            // Membuat ID pengembalian dengan format KB<tahun><bulan><no_urut>
            $now = Carbon::now();
            $yearMonth = $now->format('Ym'); // Format: YYYYMM
            $lastKembaliId = Pengembalian::where('kembali_id', 'like', 'KB' . $yearMonth . '%')
                ->orderBy('kembali_id', 'desc')
                ->first();

            $noUrut = 1;
            if ($lastKembaliId) {
                $lastNoUrut = substr($lastKembaliId->kembali_id, -3);
                $noUrut = (int)$lastNoUrut + 1;
            }

            $kembaliId = 'KB' . $yearMonth . str_pad($noUrut, 3, '0', STR_PAD_LEFT);

            $userId = Auth::user()->user_id; // Mendapatkan user_id dari pengguna yang sedang login

            Pengembalian::create([
                'kembali_id' =>  $kembaliId, // Gunakan UUID untuk unique ID
                'pb_id' => $pb_id,
                'user_id' => $userId, // Ambil user_id dari session login
                'kembali_tgl' => Carbon::now(), // Tanggal pengembalian saat ini
                'kembali_sts' => 1, // 1 = Barang berhasil dikembalikan
            ]);


            DB::commit();

            return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengembalikan barang.');
        }
    }
}
