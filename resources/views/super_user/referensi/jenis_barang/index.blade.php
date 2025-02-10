@extends('layouts.su')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Jenis Barang</h2>

    <a href="{{ route('su.jenis_barang.create') }}"
        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg mb-4 inline-block">
        Tambah Jenis Barang
    </a>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-hidden rounded-lg shadow-md">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <!-- <th class="py-3 px-6 text-left">Kode</th> -->
                    <th class="py-3 px-6 text-left">Nama Jenis Barang</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($jenisBarang as $barang)
                <tr class="border-b hover:bg-gray-100">
                    <!-- <td class="py-3 px-6">{{ $barang->jns_brg_kode }}</td> -->
                    <td class="py-3 px-6">{{ $barang->jns_brg_nama }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('su.jenis_barang.edit', $barang->jns_brg_kode) }}"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white py-1 px-3 rounded-md">Edit</a>
                        <form action="{{ route('su.jenis_barang.destroy', $barang->jns_brg_kode) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md"
                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection