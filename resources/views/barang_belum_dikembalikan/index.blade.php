@extends('layouts.operator')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Daftar Barang Belum Dikembalikan</h2>


        <!-- Menampilkan Pesan Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-4 rounded-md">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-4 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabel Daftar Barang Belum Dikembalikan -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Nama Siswa</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Barang</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Tanggal Peminjaman</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Harus Kembali</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($peminjaman as $key => $item)
                        @foreach ($item->peminjamanBarang as $peminjamanBarang)
                            @if ($peminjamanBarang->pdb_sts == 1)
                                <!-- Hanya yang masih dipinjam -->
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $item->siswa->nama_siswa }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        {{ $peminjamanBarang->barangInventaris->br_nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        {{ \Carbon\Carbon::parse($item->pb_tgl)->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        {{ \Carbon\Carbon::parse($item->pb_harus_kembali_tgl)->format('d-m-Y') }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
