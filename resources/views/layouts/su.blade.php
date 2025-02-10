<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome To Repository</title>
    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-gray-100">
    <div class="flex flex-row h-screen">
        <!-- Sidebar -->
        <aside class="bg-white border-r border-gray-300 p-6 w-64 flex flex-col shadow-lg">
            <div class="mb-4 flex items-center border-b-2 border-teal-400 pb-2">
                <img src="{{ asset('img/logo.png') }}" class="w-10">
                <strong class="ml-2 text-lg text-gray-700">Inventori</strong>
            </div>
            <nav class="flex-1 space-y-4">
                <a href="{{ route('su.dashboard.super.user') }}"
                    class="flex w-full text-gray-700 hover:text-teal-600 border-2 border-transparent hover:border-teal-500 rounded-md p-2">
                    <i class="fad fa-chart-pie mr-2"></i> Dashboard
                </a>

                <!-- Barang Dropdown -->
                <div class="relative">
                    <button
                        class="flex items-center justify-between w-full text-gray-700 hover:text-teal-600 border-2 border-transparent hover:border-teal-500 rounded-md p-2"
                        onclick="toggleDropdown('barangDropdown')">
                        <span class="flex items-center"><i class="fad fa-box mr-2"></i> Barang</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="barangDropdown" class="hidden mt-2 space-y-2 bg-gray-50 rounded-md shadow-md p-2">
                        <a href="{{ route('su.barang.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Daftar Barang</a>
                        <a href="{{ route('su.barang.create') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Penerimaan Barang</a>
                    </div>
                </div>

                <!-- Peminjaman Dropdown -->
                <div class="relative">
                    <button
                        class="flex items-center justify-between w-full text-gray-700 hover:text-teal-600 border-2 border-transparent hover:border-teal-500 rounded-md p-2"
                        onclick="toggleDropdown('peminjamanDropdown')">
                        <span class="flex items-center"><i class="fad fa-hand-holding-box mr-2"></i> Peminjaman</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="peminjamanDropdown" class="hidden mt-2 space-y-2 bg-gray-50 rounded-md shadow-md p-2">
                        <a href="{{ route('su.peminjaman.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Daftar Peminjaman</a>
                        <a href="{{ route('su.pengembalian.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Pengembalian Barang</a>
                        <a href="{{ route('su.barangbelumkembali.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Barang Belum Kembali</a>
                    </div>
                </div>

                <!-- Laporan Dropdown -->
                <div class="relative">
                    <button
                        class="flex items-center justify-between w-full text-gray-700 hover:text-teal-600 border-2 border-transparent hover:border-teal-500 rounded-md p-2"
                        onclick="toggleDropdown('laporanDropdown')">
                        <span class="flex items-center"><i class="fad fa-file-alt mr-2"></i> Laporan</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="laporanDropdown" class="hidden mt-2 space-y-2 bg-gray-50 rounded-md shadow-md p-2">
                        <a href="{{ route('su.laporan.barang') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Laporan Barang</a>
                        <a href="{{ route('su.peminjaman.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Laporan Peminjaman</a>
                        <a href="{{ route('su.barangbelumkembali.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Laporan Barang Belum
                            Kembali</a>
                    </div>
                </div>

                <!-- Referensi Dropdown -->
                <div class="relative">
                    <button
                        class="flex items-center justify-between w-full text-gray-700 hover:text-teal-600 border-2 border-transparent hover:border-teal-500 rounded-md p-2"
                        onclick="toggleDropdown('referensiDropdown')">
                        <span class="flex items-center"><i class="fad fa-book mr-2"></i> Referensi</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="referensiDropdown" class="hidden mt-2 space-y-2 bg-gray-50 rounded-md shadow-md p-2">
                        <a href="{{ route('su.jenis_barang.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Jenis Barang</a>
                        <a href="{{ route('su.siswa.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Daftar Siswa</a>
                        <a href="{{ route('su.user.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">User</a>
                    </div>
                </div>
            </nav>

            <!-- Logout Button -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" class="w-full py-2 text-center text-white bg-red-500 rounded hover:bg-red-600">
                    Logout
                </button>
            </form>
        </aside>
        <!-- End Sidebar -->

        <!-- Content -->
        <main class="flex-1 p-6 bg-white">
            @yield('content')
        </main>
    </div>

    <script>
    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle("hidden");
    }
    </script>

    @stack('script')
</body>

</html>