<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;

class BarangBelumDikembalikanController extends Controller
{
    /**
     * Menampilkan daftar barang yang belum dikembalikan.
     */
    public function index()
    {
        // Ambil semua peminjaman yang statusnya masih dipinjam (pdb_sts == 1)
        $peminjaman = Peminjaman::whereHas('peminjamanBarang', function ($query) {
            $query->belumDikembalikan(); // Menggunakan scope untuk mencari yang belum dikembalikan
        })
        ->with(['siswa', 'peminjamanBarang.barangInventaris']) // Eager load relasi siswa dan barangInventaris
        ->get();

        return view('barang_belum_dikembalikan.index', compact('peminjaman'));
    }
}
