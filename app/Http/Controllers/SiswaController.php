<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Kelas;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa.
     */
    public function index()
    {
        // Ambil semua data siswa beserta relasi jurusan dan kelas
        $siswa = Siswa::with(['jurusan', 'kelas'])->get();

        return view('referensi.siswa.index', compact('siswa'));
    }

    /**
     * Menampilkan form untuk menambahkan siswa baru.
     */
    public function create()
    {
        // Ambil data jurusan dan kelas untuk dropdown
        $jurusan = Jurusan::all();
        $kelas = Kelas::all();

        return view('referensi.siswa.create', compact('jurusan', 'kelas'));
    }

    /**
     * Menyimpan data siswa baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|numeric|unique:siswa,nisn',
            'nama_siswa' => 'required|string|max:100',
            'jurusan_id' => 'required|exists:jurusan,id',
            'kelas_id' => 'required|exists:kelas,id',
            'no_siswa' => 'nullable|string|max:20',
        ]);

        $lastSiswa = Siswa::orderBy('siswa_id', 'desc')->first();
        $lastId = $lastSiswa ? (int)substr($lastSiswa->siswa_id, 3) : 0;
        $newId = 'SIS' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        Siswa::create([
            'siswa_id' => $newId,
            'nisn' => $request->nisn,
            'nama_siswa' => $request->nama_siswa,
            'jurusan_id' => $request->jurusan_id,
            'kelas_id' => $request->kelas_id,
            'no_siswa' => $request->no_siswa,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }
}
