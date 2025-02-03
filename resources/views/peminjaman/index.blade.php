@extends('layouts.operator')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Daftar Peminjaman Barang</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 text-right">
            <a href="{{ route('peminjaman.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Peminjaman</a>
        </div>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">ID Peminjaman</th>
                    <th class="px-4 py-2 border">Nama Siswa</th>
                    <th class="px-4 py-2 border">Barang</th>
                    <th class="px-4 py-2 border">Tanggal Peminjaman</th>
                    <th class="px-4 py-2 border">Batas Kembali</th>
                    <th class="px-4 py-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman as $item)
                    <tr>
                        <td class="px-4 py-2 border">{{ $item->pb_id }}</td>
                        <td class="px-4 py-2 border">{{ $item->siswa->nama_siswa }}</td>
                        <td class="px-4 py-2 border">
                            @foreach ($item->peminjamanBarang as $barang)
                                {{ $barang->barangInventaris->br_nama }}<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->pb_tgl)->format('d M Y') }}</td>
                        <td class="px-4 py-2 border">
                            {{ \Carbon\Carbon::parse($item->pb_harus_kembali_tgl)->format('d M Y') }}</td>
                        <td class="px-4 py-2 border">{{ $item->pb_stat == '1' ? 'Aktif' : 'Selesai' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
