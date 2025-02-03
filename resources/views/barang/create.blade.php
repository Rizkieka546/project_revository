@extends('layouts.operator')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Tambah Barang</h1>
        <form action="{{ route('barang.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="jns_brg_kode" class="block text-sm font-semibold text-gray-700">Jenis Barang</label>
                <select name="jns_brg_kode" id="jns_brg_kode" class="w-full border border-gray-300 rounded-md p-2">
                    @foreach ($jenisBarang as $jenis)
                        <option value="{{ $jenis->jns_brg_kode }}">{{ $jenis->jns_brg_nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="br_nama" class="block text-sm font-semibold text-gray-700">Nama Barang</label>
                <input type="text" name="br_nama" id="br_nama" class="w-full border border-gray-300 rounded-md p-2"
                    required>
            </div>

            <div class="mb-4">
                <label for="br_tgl_terima" class="block text-sm font-semibold text-gray-700">Tanggal Terima</label>
                <input type="date" name="br_tgl_terima" id="br_tgl_terima"
                    class="w-full border border-gray-300 rounded-md p-2" required>
            </div>

            <div class="mb-4">
                <label for="br_status" class="block text-sm font-semibold text-gray-700">Status Barang</label>
                <select name="br_status" id="br_status" class="w-full border border-gray-300 rounded-md p-2" required>
                    <option value="0">Barang Dihapus</option>
                    <option value="1">Kondisi Baik</option>
                    <option value="2">Rusak, Bisa Diperbaiki</option>
                    <option value="3">Rusak, Tidak Bisa Digunakan</option>
                </select>
            </div>


            <div class="mb-4">
                <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md">Simpan</button>
                <a href="{{ route('barang.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2">Batal</a>
            </div>
        </form>
    </div>
@endsection
