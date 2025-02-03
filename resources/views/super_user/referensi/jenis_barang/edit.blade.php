@extends('layouts.su')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Jenis Barang</h2>

        <a href="{{ route('su.jenis_barang.index') }}" class="text-gray-600 hover:text-gray-800 inline-block mb-4">
            &larr; Kembali
        </a>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form action="{{ route('su.jenis_barang.update', $jenisBarang->jns_brg_kode) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="jns_brg_nama" class="block text-gray-700 font-semibold mb-2">Nama Jenis Barang</label>
                    <input type="text" id="jns_brg_nama" name="jns_brg_nama" value="{{ $jenisBarang->jns_brg_nama }}"
                        class="w-full border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-300"
                        required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg">
                    Perbarui
                </button>
            </form>
        </div>
    </div>
@endsection
