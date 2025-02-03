<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome To Cleopatra</title>
    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-20 flex items-center bg-white p-4 shadow-md">
        <div class="flex items-center w-56">
            <img src="{{ asset('img/logo.png') }}" class="w-10">
            <strong class="ml-2 text-lg text-gray-700">Inventori</strong>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="ml-auto">
            @csrf
            <button type="submit" class="text-gray-900 hover:text-red-500 transition">
                Logout
            </button>
        </form>

    </nav>
    <!-- End Navbar -->

    <div class="flex flex-row mt-16">
        <!-- Sidebar -->
        <aside class="bg-white border-r border-gray-300 p-6 w-64 h-screen shadow-lg">
            <nav class="space-y-4">
                <a href="{{ route('dashboard.admin') }}" class="flex items-center text-gray-700 hover:text-teal-600">
                    <i class="fad fa-chart-pie mr-2"></i> Dashboard
                </a>

                <!-- laporan Dropdown -->
                <div class="relative">
                    <button id="laporanDropdownBtn"
                        class="flex items-center justify-between w-full text-gray-700 hover:text-teal-600">
                        <span class="flex items-center">
                            <i class="fad fa-hand-holding-box mr-2"></i> laporan
                        </span>
                        <i class="fas fa-chevron-down transition-transform transform" id="laporanDropdownIcon"></i>
                    </button>
                    <div id="laporanDropdownMenu" class="hidden mt-2 space-y-2 bg-gray-50 rounded-md shadow-md p-2">
                        <a href="{{ route('laporan.barang') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Laporan Barang</a>
                        <a href="{{ route('laporan.pengembalian') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded"> Laporan Pengembalian
                        </a>
                        <a href="{{ route('laporan.status') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Status Barang</a>
                    </div>
                </div>
                <!-- End referensi Dropdown -->

                <!-- referensi Dropdown -->
                <div class="relative">
                    <button id="referensiDropdownBtn"
                        class="flex items-center justify-between w-full text-gray-700 hover:text-teal-600">
                        <span class="flex items-center">
                            <i class="fad fa-hand-holding-box mr-2"></i> referensi
                        </span>
                        <i class="fas fa-chevron-down transition-transform transform" id="referensiDropdownIcon"></i>
                    </button>
                    <div id="referensiDropdownMenu" class="hidden mt-2 space-y-2 bg-gray-50 rounded-md shadow-md p-2">
                        <a href="{{ route('jenis_barang.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded">Jenis Barang</a>
                        <a href="{{ route('siswa.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded"> Daftar Siswa
                        </a>
                        <a href="{{ route('user.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-teal-200 rounded"> User
                        </a>
                    </div>
                </div>
                <!-- End referensi Dropdown -->
            </nav>
        </aside>
        <!-- End Sidebar -->

        <!-- Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
        <!-- End Content -->
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // laporan Dropdown
            const laporanDropdownBtn = document.getElementById("laporanDropdownBtn");
            const laporanDropdownMenu = document.getElementById("laporanDropdownMenu");
            const laporanDropdownIcon = document.getElementById("laporanDropdownIcon");

            laporanDropdownBtn.addEventListener("click", function() {
                laporanDropdownMenu.classList.toggle("hidden");
                laporanDropdownIcon.classList.toggle("rotate-180");
            });

            // referensi Dropdown
            const referensiDropdownBtn = document.getElementById("referensiDropdownBtn");
            const referensiDropdownMenu = document.getElementById("referensiDropdownMenu");
            const referensiDropdownIcon = document.getElementById("referensiDropdownIcon");

            referensiDropdownBtn.addEventListener("click", function() {
                referensiDropdownMenu.classList.toggle("hidden");
                referensiDropdownIcon.classList.toggle("rotate-180");
            });
        });
    </script>

    @stack('script')
</body>

</html>
