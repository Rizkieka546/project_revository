@extends('layouts.operator')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Daftar Barang</h1>
        <div class="mb-4">
            <a href="{{ route('barang.create') }}" class="bg-teal-500 text-white px-4 py-2 rounded-md">Tambah Barang</a>
        </div>
        <table class="min-w-full bg-white shadow-md rounded-md">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Kode Barang</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Jenis Barang</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Tanggal Terima</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $item)
                    <tr>
                        <td class="py-2 px-4 border-b text-sm">{{ $item->br_kode }}</td>
                        <td class="py-2 px-4 border-b text-sm">{{ $item->br_nama }}</td>
                        <td class="py-2 px-4 border-b text-sm">{{ $item->jenis_barang->jns_brg_nama }}</td>
                        <td class="py-2 px-4 border-b text-sm">
                            {{ \Carbon\Carbon::parse($item->br_tgl_terima)->format('d-m-Y') }}</td>
                        <td class="py-2 px-4 border-b text-sm">
                            @if ($item->br_status == 0)
                                <span class="text-gray-500">Barang Dihapus</span>
                            @elseif ($item->br_status == 1)
                                <span class="text-green-500">Kondisi Baik</span>
                            @elseif ($item->br_status == 2)
                                <span class="text-yellow-500">Rusak, Bisa Diperbaiki</span>
                            @else
                                <span class="text-red-500">Rusak, Tidak Bisa Digunakan</span>
                            @endif
                        </td>

                        <td class="py-2 px-4 border-b text-sm">
                            <a href="{{ route('barang.edit', $item->br_kode) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('barang.destroy', $item->br_kode) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
