@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Tambah Siswa</h1>
            <a href="{{ route('siswa.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">NISN</label>
                    <input type="text" name="nisn" class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Siswa</label>
                    <input type="text" name="nama_siswa" class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Jurusan</label>
                    <select name="jurusan_id" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Kelas</label>
                    <select name="kelas_id" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">No. Siswa (Opsional)</label>
                    <input type="text" name="no_siswa" class="w-full px-4 py-2 border rounded-lg">
                </div>

                <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600">
                    Simpan
                </button>
            </form>
        </div>
    </div>
@endsection
