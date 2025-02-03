@extends('layouts.su')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Daftar Siswa</h1>
            <a href="{{ route('su.siswa.create') }}" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                Tambah Siswa
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full table-auto">
                <thead class="bg-teal-500 text-white">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">NISN</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Jurusan</th>
                        <th class="px-4 py-2">Kelas</th>
                        <th class="px-4 py-2">No. Siswa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $index => $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $item->nisn }}</td>
                            <td class="px-4 py-2">{{ $item->nama_siswa }}</td>
                            <td class="px-4 py-2">{{ $item->jurusan->nama_jurusan }}</td>
                            <td class="px-4 py-2">{{ $item->kelas->nama_kelas }}</td>
                            <td class="px-4 py-2">{{ $item->no_siswa ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
