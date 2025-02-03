@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-6">Daftar User</h2>
        
        <!-- Tombol Tambah User -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('user.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-300">
                Tambah User
            </a>
        </div>
        
        <!-- Tabel Daftar User -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-700">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Hak Akses</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $user->user_nama }}</td>
                            <td class="px-4 py-2 capitalize">{{ $user->user_hak }}</td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 rounded-full 
                                    {{ $user->user_sts == '1' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $user->user_sts == '1' ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <!-- Tombol Edit -->
                                <a href="{{ route('user.edit', $user->user_id) }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded-md shadow-md transition duration-300 mr-2">
                                    Edit
                                </a>

                                <!-- Form Hapus -->
                                <form action="{{ route('user.destroy', $user->user_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded-md shadow-md transition duration-300">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
