<?php

namespace App\Http\Controllers;

use App\Models\BarangInventaris;
use App\Models\JenisBarang;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use App\Models\Pengembalian;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SUController extends Controller
{
    /**
     * Menampilkan halaman dashboard super user.
     */
    public function index()
    {
        // Data untuk statistik
        $jumlahBarang = BarangInventaris::count();
        $jumlahPeminjaman = Peminjaman::count();

        // Grafik transaksi peminjaman harian
        $dataGrafik = Peminjaman::selectRaw('DATE(pb_tgl) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->tanggal)->format('Y-m-d') => $item->jumlah];
            });

        // Persiapan data grafik untuk bulan saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $daysInMonth = Carbon::now()->daysInMonth;

        $labels = [];
        $formattedData = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
            $labels[] = Carbon::create($currentYear, $currentMonth, $day)->format('d-m-Y');
            $formattedData[] = $dataGrafik[$date] ?? 0;
        }

        // Kirim data ke view
        return view('super_user.dashboard.super_user', compact('jumlahBarang', 'jumlahPeminjaman', 'labels', 'formattedData'));
    }

    public function indexBBK(Request $request)
    {
        $search = $request->input('search');

        // Ambil semua barang yang statusnya masih dipinjam (pdb_sts == 1)
        $peminjaman = Peminjaman::whereHas('peminjamanBarang', function ($query) use ($search) {
            $query->where('pdb_sts', 1); // 1 = Masih dipinjam

            if ($search) {
                $query->whereHas('barangInventaris', function ($subQuery) use ($search) {
                    $subQuery->where('br_nama', 'like', "%$search%");
                });
            }
        })
            ->whereHas('siswa', function ($query) use ($search) {
                if ($search) {
                    $query->where('nama_siswa', 'like', "%$search%");
                }
            })
            ->with(['siswa', 'peminjamanBarang.barangInventaris'])
            ->get();

        return view('super_user.barang_belum_dikembalikan.index', compact('peminjaman', 'search'));
    }

    public function indexB()
    {
        $barang = BarangInventaris::with('jenis_barang')->get();
        return view('super_user.barang.index', compact('barang'));
    }

    public function createB()
    {
        $jenisBarang = JenisBarang::all();
        return view('super_user.barang.create', compact('jenisBarang'));
    }

    public function storeB(Request $request)
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
        BarangInventaris::create([
            'br_kode' => $brKode,
            'jns_brg_kode' => $request->jns_brg_kode,
            'user_id' => 'U001',
            'br_nama' => $request->br_nama,
            'br_tgl_terima' => $request->br_tgl_terima,
            'br_tgl_entry' => now(),
            'br_status' => $request->br_status,
        ]);

        return redirect()->route('su.barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }


    public function editB($br_kode)
    {
        $barang = BarangInventaris::where('br_kode', $br_kode)->firstOrFail();
        $jenisBarang = JenisBarang::all();
        return view('super_user.barang.edit', compact('barang', 'jenisBarang'));
    }

    public function updateB(Request $request, $br_kode)
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

        return redirect()->route('su.barang.index')->with('success', 'Barang berhasil diperbarui!');
    }


    public function destroyB($br_kode)
    {
        BarangInventaris::where('br_kode', $br_kode)->delete();
        return redirect()->route('su.barang.index')->with('success', 'Barang berhasil dihapus!');
    }

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

        return view('super_user.laporan.barang', compact('barang', 'startDate', 'endDate'));
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
        return view('super_user.laporan.pengembalian', compact('pengembalian', 'startDate', 'endDate'));
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
        return view('super_user.laporan.status-barang', compact('barang', 'status'));
    }

    public function indexPM()
    {
        // Mengambil semua data peminjaman beserta relasi siswa dan peminjaman barang
        $peminjaman = Peminjaman::with(['siswa', 'peminjamanBarang.barangInventaris'])->get();
        return view('super_user.peminjaman.index', compact('peminjaman'));
    }


    public function createPM()
    {
        // Mengambil semua data siswa
        $siswa = Siswa::all();

        // Mengambil barang yang belum dipinjam (berstatus 1 pada td_peminjaman_barang)
        $barang = BarangInventaris::whereNotIn('br_kode', function ($query) {
            $query->select('br_kode')->from('td_peminjaman_barang')->where('pdb_sts', 1);
        })->get();

        return view('super_user.peminjaman.create', compact('siswa', 'barang'));
    }

    public function storePM(Request $request)
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

            return redirect()->route('su.peminjaman.index')->with('success', 'Peminjaman barang berhasil dilakukan!');
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexPengembalian()
    {
        // Ambil semua peminjaman yang statusnya 'Dipinjam' (pb_stat == 1)
        $peminjaman = Peminjaman::where('pb_stat', 1)
            ->with(['siswa', 'peminjamanBarang.barangInventaris'])
            ->get();

        return view('super_user.pengembalian.index', compact('peminjaman'));
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

            $userId = Auth::user()->user_id;

            Pengembalian::create([
                'kembali_id' =>  $kembaliId,
                'pb_id' => $pb_id,
                'user_id' => $userId,
                'kembali_tgl' => Carbon::now(),
                'kembali_sts' => 1,
            ]);


            DB::commit();

            return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengembalikan barang.');
        }
    }

    public function jnsindex()
    {
        $jenisBarang = JenisBarang::all();
        return view('super_user.referensi.jenis_barang.index', compact('jenisBarang'));
    }

    public function jnscreate()
    {
        $jenisBarang = JenisBarang::all();
        return view('super_user.referensi.jenis_barang.create', compact('jenisBarang'));
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

        return redirect()->route('su.jenis_barang.index')->with('success', 'Jenis barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jenis barang.
     */
    public function jnsedit($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);
        return view('super_user.referensi.jenis_barang.edit', compact('jenisBarang'));
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

        return redirect()->route('su.jenis_barang.index')->with('success', 'Jenis barang berhasil diperbarui.');
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

    public function indexS()
    {
        // Ambil semua data siswa beserta relasi jurusan dan kelas
        $siswa = Siswa::with(['jurusan', 'kelas'])->get();

        return view('super_user.referensi.siswa.index', compact('siswa'));
    }

    /**
     * Menampilkan form untuk menambahkan siswa baru.
     */
    public function createS()
    {
        // Ambil data jurusan dan kelas untuk dropdown
        $jurusan = Jurusan::all();
        $kelas = Kelas::all();

        return view('super_user.referensi.siswa.create', compact('jurusan', 'kelas'));
    }

    /**
     * Menyimpan data siswa baru ke database.
     */
    public function storeS(Request $request)
    {
        // Validasi input
        $request->validate([
            'nisn' => 'required|numeric|unique:siswa,nisn',
            'nama_siswa' => 'required|string|max:100',
            'jurusan_id' => 'required|exists:jurusan,id',
            'kelas_id' => 'required|exists:kelas,id',
            'no_siswa' => 'nullable|string|max:20',
        ]);

        // Generate ID siswa baru dengan format SIS001, SIS002, ...
        $lastSiswa = Siswa::orderBy('siswa_id', 'desc')->first();
        $lastId = $lastSiswa ? (int)substr($lastSiswa->siswa_id, 3) : 0;
        $newId = 'SIS' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        // Simpan data siswa ke database
        Siswa::create([
            'siswa_id' => $newId,
            'nisn' => $request->nisn,
            'nama_siswa' => $request->nama_siswa,
            'jurusan_id' => $request->jurusan_id,
            'kelas_id' => $request->kelas_id,
            'no_siswa' => $request->no_siswa,
        ]);

        return redirect()->route('su.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    // Menampilkan daftar semua user
    // Menampilkan daftar semua user
    public function userindex()
    {
        $users = User::all();
        return view('super_user.referensi.user.index', compact('users'));
    }

    // Menampilkan form untuk membuat user baru
    public function usercreate()
    {
        return view('super_user.referensi.user.create');
    }

    // Fungsi untuk generate user_id otomatis
    private function generateUserId()
    {
        $latestUser = User::orderBy('user_id', 'desc')->first();
        if ($latestUser) {
            // Ambil angka terakhir dan tambahkan 1
            $lastUserId = (int) substr($latestUser->user_id, 1); // Ambil angka setelah 'U'
            $newUserId = 'U' . str_pad($lastUserId + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada data user, maka user_id pertama adalah U001
            $newUserId = 'U001';
        }

        return $newUserId;
    }

    // Menyimpan data user baru
    public function userstore(Request $request)
    {
        $validatedData = $request->validate([
            'user_nama' => 'required|string|max:50',
            'user_pass' => 'required|string|min:6',
            'user_hak' => 'required|in:su,admin,operator',
            'user_sts' => 'required|in:0,1',
        ]);

        // Generate user_id otomatis
        $user_id = $this->generateUserId();

        $user = new User();
        $user->user_id = $user_id;
        $user->user_nama = $request->user_nama;
        $user->user_pass = bcrypt($request->user_pass); // Encrypt password
        $user->user_hak = $request->user_hak;
        $user->user_sts = $request->user_sts;
        $user->save();

        return redirect()->route('su.user.index')->with('success', 'User berhasil dibuat!');
    }

    // Menampilkan form untuk mengedit data user
    public function useredit($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('super_user.referensi.user.edit', compact('user'));
    }

    // Mengupdate data user
    public function userupdate(Request $request, $user_id)
    {
        $validatedData = $request->validate([
            'user_nama' => 'required|string|max:50',
            'user_pass' => 'nullable|string|min:6', // Password bersifat opsional saat update
            'user_hak' => 'required|in:su,admin,operator',
            'user_sts' => 'required|in:0,1',
        ]);

        $user = User::findOrFail($user_id);
        $user->user_nama = $request->user_nama;

        // Jika password baru diberikan, enkripsi dan update
        if ($request->user_pass) {
            $user->user_pass = bcrypt($request->user_pass);
        }

        $user->user_hak = $request->user_hak;
        $user->user_sts = $request->user_sts;
        $user->save();

        return redirect()->route('su.user.index')->with('success', 'User berhasil diperbarui!');
    }

    // Menghapus data user
    public function userdestroy($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect()->route('su.user.index')->with('success', 'User berhasil dihapus!');
    }
}
