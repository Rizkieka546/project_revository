<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangInventaris;
use App\Models\JenisBarang;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index()
    {
        $barang = BarangInventaris::with('jenis_barang')->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $jenisBarang = JenisBarang::all();
        return view('barang.create', compact('jenisBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jns_brg_kode' => 'required|exists:tr_jenis_barang,jns_brg_kode',
            'br_nama' => 'required|string|max:255',
            'br_tgl_terima' => 'required|date',
            'br_status' => 'required|in:0,1,2',
        ]);

        // Ambil kode terakhir berdasarkan tahun yang sama
        $year = date('Y');
        $lastBarang = BarangInventaris::where('br_kode', 'LIKE', "INV{$year}%")
            ->orderBy('br_kode', 'desc')
            ->first();

        // Jika ada kode sebelumnya, ambil angka berikutnya
        if ($lastBarang) {
            $lastNumber = (int) substr($lastBarang->br_kode, 7); // Ambil angka dari kode terakhir
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format kode barang baru
        $brKode = sprintf('INV%s%05d', $year, $nextNumber);

        // Cek apakah kode sudah ada di database (menghindari duplikasi)
        while (BarangInventaris::where('br_kode', $brKode)->exists()) {
            $nextNumber++;
            $brKode = sprintf('INV%s%05d', $year, $nextNumber);
        }

        // Simpan ke database
        $userId = Auth::user()->user_id;

        BarangInventaris::create([
            'br_kode' => $brKode,
            'jns_brg_kode' => $request->jns_brg_kode,
            'user_id' => $userId,
            'br_nama' => $request->br_nama,
            'br_tgl_terima' => $request->br_tgl_terima,
            'br_tgl_entry' => now(),
            'br_status' => $request->br_status,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }


    public function edit($br_kode)
    {
        $barang = BarangInventaris::where('br_kode', $br_kode)->firstOrFail();
        $jenisBarang = JenisBarang::all();
        return view('barang.edit', compact('barang', 'jenisBarang'));
    }

    public function update(Request $request, $br_kode)
    {
        $request->validate([
            'jns_brg_kode' => 'required|exists:tr_jenis_barang,jns_brg_kode',
            'br_nama' => 'required|string|max:255',
            'br_tgl_terima' => 'required|date',
            'br_status' => 'required|in:0,1,2',
        ]);

        $barang = BarangInventaris::where('br_kode', $br_kode)->firstOrFail();
        $barang->update([
            'jns_brg_kode' => $request->jns_brg_kode,
            'br_nama' => $request->br_nama,
            'br_tgl_terima' => $request->br_tgl_terima,
            'br_status' => $request->br_status,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }


    public function destroy($br_kode)
    {
        BarangInventaris::where('br_kode', $br_kode)->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}
