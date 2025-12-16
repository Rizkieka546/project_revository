@extends('layouts.su')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Laporan Barang</h2>

    <!-- Form Filter Tanggal -->
    <form action="{{ route('su.laporan.barang') }}" method="GET" class="mb-6 flex items-center space-x-4">
        <div class="flex space-x-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="px-4 py-2 border border-teal-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="px-4 py-2 border border-teal-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit"
                class="bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded-lg text-sm font-semibold">Filter</button>
        </div>
    </form>

    <!-- Tabel Daftar Barang -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-teal-400 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Nama Barang</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Kode Barang</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Tanggal Diterima</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-teal-200">
                @forelse ($barang as $key => $item)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $item->br_nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $item->br_kode }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        {{ \Carbon\Carbon::parse($item->br_tgl_terima)->format('d-m-Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-800">Tidak ada barang yang
                        ditemukan untuk rentang tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection