@extends('layouts.su')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6 border-b-2 border-teal-300 pb-2">Daftar Peminjaman Barang</h1>

    @if (session('success'))
    <div class="bg-green-500 text-white p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4 text-right">
        <a href="{{ route('su.peminjaman.create') }}"
            class="bg-teal-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-teal-700 transition-transform transform hover:scale-105">
            Tambah Peminjaman
        </a>
    </div>

    <!-- Tabel Peminjaman Aktif -->
    <h2 class="text-xl font-semibold text-gray-600 mb-2">Peminjaman Aktif</h2>
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg border border-gray-200 mb-6">
        <table class="min-w-full divide-y divide-teal-300">
            <thead class="text-teal-400 bg-teal-400 text-white">
                <tr class="text-left uppercase text-sm font-semibold">
                    <th class="py-3 px-6">ID Peminjaman</th>
                    <th class="py-3 px-6">Nama Siswa</th>
                    <th class="py-3 px-6">Barang</th>
                    <th class="py-3 px-6">Tanggal Peminjaman</th>
                    <th class="py-3 px-6">Batas Kembali</th>
                    <th class="py-3 px-6">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-teal-200 border border-teal-400">
                @foreach ($peminjaman->where('pb_stat', 1) as $item)
                <tr class="hover:bg-gray-100 transition duration-300">
                    <td class="py-4 px-6 text-gray-800 font-medium">{{ $item->pb_id }}</td>
                    <td class="py-4 px-6 text-gray-800">{{ $item->siswa->nama_siswa }}</td>
                    <td class="py-4 px-6 text-gray-800">
                        @foreach ($item->peminjamanBarang as $barang)
                        {{ $barang->barangInventaris->br_nama }}<br>
                        @endforeach
                    </td>
                    <td class="py-4 px-6 text-gray-800">{{ \Carbon\Carbon::parse($item->pb_tgl)->format('d-m-Y') }}</td>
                    <td class="py-4 px-6 text-gray-800">
                        {{ \Carbon\Carbon::parse($item->pb_harus_kembali_tgl)->format('d-m-Y') }}
                    </td>
                    <td class="py-4 px-6 text-green-600 font-semibold">Aktif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabel Peminjaman Selesai -->
    <h2 class="text-xl font-semibold text-gray-600 mb-2">Peminjaman Selesai</h2>
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-teal-300">
            <thead class="text-teal-400 bg-teal-400 text-white">
                <tr class="text-left uppercase text-sm font-semibold">
                    <th class="py-3 px-6">ID Peminjaman</th>
                    <th class="py-3 px-6">Nama Siswa</th>
                    <th class="py-3 px-6">Barang</th>
                    <th class="py-3 px-6">Tanggal Peminjaman</th>
                    <th class="py-3 px-6">Batas Kembali</th>
                    <th class="py-3 px-6">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-teal-200 border border-teal-400">
                @foreach ($peminjaman->where('pb_stat', 0) as $item)
                <tr class="hover:bg-gray-100 transition duration-300">
                    <td class="py-4 px-6 text-gray-800 font-medium">{{ $item->pb_id }}</td>
                    <td class="py-4 px-6 text-gray-800">{{ $item->siswa->nama_siswa }}</td>
                    <td class="py-4 px-6 text-gray-800">
                        @foreach ($item->peminjamanBarang as $barang)
                        {{ $barang->barangInventaris->br_nama }}<br>
                        @endforeach
                    </td>
                    <td class="py-4 px-6 text-gray-800">{{ \Carbon\Carbon::parse($item->pb_tgl)->format('d-m-Y') }}</td>
                    <td class="py-4 px-6 text-gray-800">
                        {{ \Carbon\Carbon::parse($item->pb_harus_kembali_tgl)->format('d-m-Y') }}
                    </td>
                    <td class="py-4 px-6 text-red-600 font-semibold">Selesai</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection