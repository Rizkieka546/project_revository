@extends('layouts.su')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-6">Tambah User</h2>

        <form action="{{ route('su.user.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="user_nama" class="block text-gray-700 font-semibold">Nama</label>
                <input type="text" class="w-full p-3 mt-2 border border-gray-300 rounded-md" id="user_nama"
                    name="user_nama" required>
            </div>

            <div class="mb-4">
                <label for="user_pass" class="block text-gray-700 font-semibold">Password</label>
                <input type="password" class="w-full p-3 mt-2 border border-gray-300 rounded-md" id="user_pass"
                    name="user_pass" required>
            </div>

            <div class="mb-4">
                <label for="user_hak" class="block text-gray-700 font-semibold">Hak Akses</label>
                <select class="w-full p-3 mt-2 border border-gray-300 rounded-md" id="user_hak" name="user_hak" required>
                    <option value="su">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="operator">Operator</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="user_sts" class="block text-gray-700 font-semibold">Status</label>
                <select class="w-full p-3 mt-2 border border-gray-300 rounded-md" id="user_sts" name="user_sts" required>
                    <option value="1">Aktif</option>
                    <option value="0">Non-Aktif</option>
                </select>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="w-full p-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
