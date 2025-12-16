@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Daftar Peminjaman Barang</h2>

    @if (session('success'))
    <div class="alert alert-success bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-4 rounded-md">
        {{ session('success') }}
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-4 rounded-md">
        {{ session('error') }}
    </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Nama Siswa</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Barang</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Tanggal Peminjaman</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status Pengembalian</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-teal-200">
                @foreach ($peminjaman as $key => $item)
                @foreach ($item->peminjamanBarang as $peminjamanBarang)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $item->siswa->nama_siswa }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        {{ $peminjamanBarang->barangInventaris->br_nama }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        {{ \Carbon\Carbon::parse($item->pb_tgl)->format('d-m-Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if ($peminjamanBarang->pdb_sts == 1)
                        <span
                            class="px-2 py-1 inline-block bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Belum
                            Dikembalikan</span>
                        @else
                        <span
                            class="px-2 py-1 inline-block bg-green-100 text-green-800 rounded-full text-xs font-semibold">Sudah
                            Dikembalikan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if ($peminjamanBarang->pdb_sts == 1)
                        <form
                            action="{{ route('pengembalian.kembalikan', ['pb_id' => $item->pb_id, 'br_kode' => $peminjamanBarang->br_kode]) }}"
                            method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan barang ini?');">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-blue-300">Kembalikan</button>
                        </form>
                        @else
                        <button
                            class="bg-gray-400 text-white py-2 px-4 rounded-lg text-sm font-semibold cursor-not-allowed"
                            disabled>Sudah Dikembalikan</button>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection