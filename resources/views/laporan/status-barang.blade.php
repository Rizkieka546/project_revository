@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Laporan Status Barang</h2>

    <!-- Form Filter Status Barang -->
    <form action="{{ route('laporan.status') }}" method="GET" class="mb-6 flex items-center space-x-4">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status Barang</label>
            <select name="status"
                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="" disabled selected>Pilih Status</option>
                <option value="0" {{ $status == '0' ? 'selected' : '' }}>Barang Dihapus</option>
                <option value="1" {{ $status == '1' ? 'selected' : '' }}>Kondisi Baik</option>
                <option value="2" {{ $status == '2' ? 'selected' : '' }}>Rusak, Bisa Diperbaiki</option>
                <option value="3" {{ $status == '3' ? 'selected' : '' }}>Rusak, Tidak Bisa Digunakan</option>
            </select>
        </div>
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-semibold">Filter</button>
    </form>


    <!-- Tabel Daftar Barang Berdasarkan Status -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Nama Barang</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Kode Barang</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status Barang</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-teal-200">
                @forelse ($barang as $key => $item)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $item->br_nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $item->br_kode }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        @if ($item->br_status == 0)
                        Barang Dihapus
                        @elseif ($item->br_status == 1)
                        Kondisi Baik
                        @elseif ($item->br_status == 2)
                        Rusak, Bisa Diperbaiki
                        @else
                        Rusak, Tidak Bisa Digunakan
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-800">Tidak ada barang dengan
                        status yang dipilih.</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>
@endsection