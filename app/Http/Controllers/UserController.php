<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan daftar semua user
    public function index()
    {
        $users = User::all();
        return view('super_user.referensi.user.index', compact('users'));
    }

    // Menampilkan form untuk membuat user baru
    public function create()
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
    public function store(Request $request)
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

        return redirect()->route('user.index')->with('success', 'User berhasil dibuat!');
    }

    // Menampilkan form untuk mengedit data user
    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('super_user.referensi.user.edit', compact('user'));
    }

    // Mengupdate data user
    public function update(Request $request, $user_id)
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

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
    }

    // Menghapus data user
    public function destroy($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}
