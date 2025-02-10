@extends('layouts.su')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6 border-b-2 border-teal-300 pb-2">Daftar Barang</h1>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="text-teal-400 bg-teal-400 text-white">
                <tr class="text-left uppercase text-sm font-semibold">
                    <th class="py-3 px-6">Nama Barang</th>
                    <th class="py-3 px-6">Jenis Barang</th>
                    <th class="py-3 px-6">Tanggal Terima</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 border border-teal-400">
                @foreach ($barang as $item)
                <tr class="hover:bg-gray-100 transition duration-300">
                    <td class="py-4 px-6 text-gray-800 font-medium">{{ $item->br_nama }}</td>
                    <td class="py-4 px-6 text-gray-800">{{ $item->jenis_barang->jns_brg_nama }}</td>
                    <td class="py-4 px-6 text-gray-800">
                        {{ \Carbon\Carbon::parse($item->br_tgl_terima)->format('d-m-Y') }}
                    </td>
                    <td class="py-4 px-6">
                        @php
                        $statusClasses = [
                        '0' => 'bg-gray-300 text-gray-700',
                        '1' => 'bg-green-300 text-green-800',
                        '2' => 'bg-yellow-300 text-yellow-800',
                        '3' => 'bg-red-300 text-red-800',
                        ];
                        $statusText = ['Dihapus', 'Baik', 'Dapat Diperbaiki', 'Tidak Bisa Digunakan'];
                        @endphp
                        <span
                            class="px-3 py-1 rounded-full text-xs {{ $statusClasses[$item->br_status] ?? 'bg-gray-300' }}">
                            {{ $statusText[$item->br_status] ?? 'Tidak Diketahui' }}
                        </span>
                    </td>
                    <td class="py-4 px-6 flex justify-center gap-3">
                        <a href="{{ route('su.barang.edit', $item->br_kode) }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-transform transform hover:scale-105">
                            Edit
                        </a>
                        <form action="{{ route('su.barang.destroy', $item->br_kode) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-transform transform hover:scale-105">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection