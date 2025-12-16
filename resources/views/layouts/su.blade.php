<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventori Dashboard</title>

    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-100 to-slate-200">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-72 bg-white/80 backdrop-blur-xl border-r border-slate-200 shadow-xl flex flex-col">

            <!-- Logo -->
            <div class="px-6 py-5 flex items-center gap-3 border-b border-slate-200">
                <img src="{{ asset('img/logo.png') }}" class="w-9 h-9">
                <span class="text-xl font-bold text-slate-700 tracking-tight">
                    Inventori
                </span>
            </div>

            <!-- Menu -->
            <nav class="flex-1 px-4 py-6 space-y-2 text-slate-600 text-sm">

                <!-- Dashboard -->
                <a href="{{ route('su.dashboard.super.user') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-teal-500 hover:text-white transition-all duration-200">
                    <i class="fad fa-chart-pie text-lg"></i>
                    Dashboard
                </a>

                <!-- Dropdown -->
                @php
                    $menus = [
                        ['id'=>'barang','icon'=>'fa-box','title'=>'Barang', 'items'=>[
                            ['Daftar Barang', 'su.barang.index'],
                            ['Penerimaan Barang', 'su.barang.create'],
                        ]],
                        ['id'=>'peminjaman','icon'=>'fa-hand-holding-box','title'=>'Peminjaman', 'items'=>[
                            ['Daftar Peminjaman', 'su.peminjaman.index'],
                            ['Pengembalian Barang', 'su.pengembalian.index'],
                            ['Barang Belum Kembali', 'su.barangbelumkembali.index'],
                        ]],
                        ['id'=>'laporan','icon'=>'fa-file-alt','title'=>'Laporan', 'items'=>[
                            ['Laporan Barang', 'su.laporan.barang'],
                            ['Laporan Pengembalian', 'su.pengembalian.index'],
                            ['Barang Belum Kembali', 'su.barangbelumkembali.index'],
                        ]],
                        ['id'=>'referensi','icon'=>'fa-book','title'=>'Referensi', 'items'=>[
                            ['Jenis Barang', 'su.jenis_barang.index'],
                            ['Daftar Siswa', 'su.siswa.index'],
                            ['User', 'su.user.index'],
                        ]]
                    ];
                @endphp

                @foreach($menus as $menu)
                <div>
                    <button onclick="toggle('{{ $menu['id'] }}')"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-xl hover:bg-slate-100 transition">
                        <span class="flex items-center gap-3">
                            <i class="fad {{ $menu['icon'] }} text-lg"></i>
                            {{ $menu['title'] }}
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>

                    <div id="{{ $menu['id'] }}" class="hidden ml-8 mt-2 space-y-1">
                        @foreach($menu['items'] as $item)
                        <a href="{{ route($item[1]) }}"
                           class="block px-4 py-2 rounded-lg hover:bg-teal-100 hover:text-teal-700 transition">
                            {{ $item[0] }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </nav>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="p-4">
                @csrf
                <button
                    class="w-full py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition">
                    Logout
                </button>
            </form>

        </aside>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="bg-white rounded-2xl shadow-md p-6 min-h-full">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggle(id) {
            document.getElementById(id).classList.toggle('hidden')
        }
    </script>

    @stack('script')
</body>

</html>
