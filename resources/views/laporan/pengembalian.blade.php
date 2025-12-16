@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Laporan Pengembalian Barang</h2>

    <!-- Form Filter Tanggal -->
    <form action="{{ route('laporan.pengembalian') }}" method="GET" class="mb-6 flex items-center space-x-4">
        <div class="flex space-x-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-semibold">Filter</button>
        </div>
    </form>

    <!-- Tabel Daftar Pengembalian -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Nama Siswa</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Nama Barang</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Tanggal Pengembalian</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-teal-200">
                @forelse ($pengembalian as $key => $item)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $item->peminjaman->siswa->nama_siswa }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        @foreach($item->peminjaman->peminjamanBarang as $barang)
                        <div>{{ $barang->barangInventaris->br_nama }}</div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        {{ \Carbon\Carbon::parse($item->kembali_tgl)->format('d-m-Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-800">Tidak ada data pengembalian dalam rentang tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection