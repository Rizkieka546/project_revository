@extends('layouts.su')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6 border-b-2 border-teal-300 pb-2">Pengembalian Barang</h1>

    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-4 rounded-md">
        {{ session('success') }}
    </div>
    @elseif(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-4 rounded-md">
        {{ session('error') }}
    </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-teal-300">
            <thead class="text-teal-400 bg-teal-400 text-white">
                <tr class="text-left uppercase text-sm font-semibold">
                    <th class="py-3 px-6">#</th>
                    <th class="py-3 px-6">Nama Siswa</th>
                    <th class="py-3 px-6">Barang</th>
                    <th class="py-3 px-6">Tanggal Peminjaman</th>
                    <th class="py-3 px-6">Tanggal Tenggat</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-teal-200 border border-teal-400">
                @php $nomor = 1; @endphp
                @foreach ($peminjaman as $item)
                @foreach ($item->peminjamanBarang as $peminjamanBarang)
                <tr class="hover:bg-gray-100 transition duration-300">
                    <td class="py-4 px-6 text-gray-800">{{ $nomor++ }}</td>
                    <td class="py-4 px-6 text-gray-800 font-medium">{{ $item->siswa->nama_siswa }}</td>
                    <td class="py-4 px-6 text-gray-800 font-semibold">{{ $peminjamanBarang->barangInventaris->br_nama }}
                    </td>
                    <td class="py-4 px-6 text-gray-800">{{ \Carbon\Carbon::parse($item->pb_tgl)->format('d-m-Y') }}</td>
                    <td class="py-4 px-6 text-gray-800">
                        {{ \Carbon\Carbon::parse($item->pb_harus_kembali_tgl)->format('d-m-Y') }}
                    </td>

                    <td class="py-4 px-6 flex justify-center gap-3">
                        @if ($peminjamanBarang->pdb_sts == 1)
                        <form
                            action="{{ route('su.pengembalian.kembalikan', ['pb_id' => $item->pb_id, 'br_kode' => $peminjamanBarang->br_kode]) }}"
                            method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan barang ini?');">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-transform transform hover:scale-105">
                                Kembalikan
                            </button>
                        </form>
                        @else
                        <button
                            class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-semibold cursor-not-allowed">
                            Sudah Dikembalikan
                        </button>
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