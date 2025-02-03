@extends('layouts.su')

@section('content')
    <div class="container mx-auto px-4 py-6 text-black">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Form Peminjaman Barang</h1>

        <form action="{{ route('su.peminjaman.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="siswa_id" class="block text-gray-700">Nama Siswa</label>
                <select id="siswa_id" name="siswa_id" class="w-full border border-gray-300 px-4 py-2 rounded" required>
                    <option value="">Pilih Siswa</option>
                    @foreach ($siswa as $item)
                        <option value="{{ $item->siswa_id }}">{{ $item->nama_siswa }}</option>
                    @endforeach
                </select>
                @error('siswa_id')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="br_kode" class="block text-gray-700">Barang</label>
                <select id="br_kode" name="br_kode" class="w-full border border-gray-300 px-4 py-2 rounded" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($barang as $item)
                        <option value="{{ $item->br_kode }}">{{ $item->br_nama }}</option>
                    @endforeach
                </select>
                @error('br_kode')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pb_tgl" class="block text-gray-700">Tanggal Peminjaman</label>
                <input type="date" id="pb_tgl" name="pb_tgl" class="w-full border border-gray-300 px-4 py-2 rounded"
                    required>
                @error('pb_tgl')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Peminjaman</button>
            </div>
        </form>
    </div>
@endsection
