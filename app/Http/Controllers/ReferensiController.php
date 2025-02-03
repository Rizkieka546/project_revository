<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class ReferensiController extends Controller
{
    public function jnsindex()
    {
        $jenisBarang = JenisBarang::all();
        return view('referensi.jenis_barang.index', compact('jenisBarang'));
    }

    public function jnscreate()
    {
        $jenisBarang = JenisBarang::all();
        return view('referensi.jenis_barang.create', compact('jenisBarang'));
    }

    /**
     * Membuat kode baru secara otomatis dengan format JNS001, JNS002, dst.
     */
    private function jnsgenerateKode()
    {
        $lastBarang = JenisBarang::orderBy('jns_brg_kode', 'desc')->first();

        if (!$lastBarang) {
            return 'JNS01';
        }

        // Ambil angka terakhir dari kode (misal JNS05 → 5)
        $lastKode = intval(substr($lastBarang->jns_brg_kode, 3));

        // Tambah 1 untuk kode berikutnya
        $newKode = 'JNS' . str_pad($lastKode + 1, 2, '0', STR_PAD_LEFT);

        return $newKode;
    }



    /**
     * Menyimpan jenis barang baru ke database.
     */
    public function jnsstore(Request $request)
    {
        $request->validate([
            'jns_brg_nama' => 'required|string|max:255|unique:tr_jenis_barang,jns_brg_nama',
        ]);

        JenisBarang::create([
            'jns_brg_kode' => $this->jnsgenerateKode(),
            'jns_brg_nama' => $request->jns_brg_nama,
        ]);

        return redirect()->route('jenis_barang.index')->with('success', 'Jenis barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jenis barang.
     */
    public function jnsedit($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);
        return view('referensi.jenis_barang.edit', compact('jenisBarang'));
    }

    /**
     * Update jenis barang di database.
     */
    public function jnsupdate(Request $request, $id)
    {
        $request->validate([
            'jns_brg_nama' => 'required|string|max:255|unique:tr_jenis_barang,jns_brg_nama,' . $id . ',jns_brg_kode',
        ]);

        $jenisBarang = JenisBarang::findOrFail($id);
        $jenisBarang->update([
            'jns_brg_nama' => $request->jns_brg_nama,
        ]);

        return redirect()->route('jenis_barang.index')->with('success', 'Jenis barang berhasil diperbarui.');
    }

    /**
     * Menghapus jenis barang dari database.
     */
    public function jnsdestroy($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);
        $jenisBarang->delete();

        return redirect()->back()->with('success', 'Jenis barang berhasil dihapus.');
    }
}
