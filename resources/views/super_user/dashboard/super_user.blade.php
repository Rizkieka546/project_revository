@extends('layouts.su')

@section('content')

<!-- STAT CARDS -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Jumlah Barang -->
    <div class="relative rounded-2xl bg-gradient-to-br from-yellow-100 to-yellow-50 p-6 shadow-md">
        <div class="absolute -top-6 -right-6 text-yellow-300 text-7xl opacity-30">
            <i class="fas fa-box"></i>
        </div>

        <p class="text-sm text-gray-500">Total</p>
        <h2 class="text-lg font-semibold text-gray-700">Jumlah Barang</h2>

        <div class="mt-6 flex justify-between items-center">
            <span class="text-4xl font-bold text-gray-800">
                {{ $jumlahBarang }}
            </span>
            <div class="w-12 h-12 bg-yellow-400 rounded-xl flex items-center justify-center text-white">
                <i class="fas fa-box"></i>
            </div>
        </div>
    </div>

    <!-- Jumlah Peminjaman -->
    <div class="relative rounded-2xl bg-gradient-to-br from-teal-100 to-teal-50 p-6 shadow-md">
        <div class="absolute -top-6 -right-6 text-teal-300 text-7xl opacity-30">
            <i class="fas fa-clipboard-list"></i>
        </div>

        <p class="text-sm text-gray-500">Total</p>
        <h2 class="text-lg font-semibold text-gray-700">Jumlah Peminjaman</h2>

        <div class="mt-6 flex justify-between items-center">
            <span class="text-4xl font-bold text-gray-800">
                {{ $jumlahPeminjaman }}
            </span>
            <div class="w-12 h-12 bg-teal-500 rounded-xl flex items-center justify-center text-white">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>

</div>

<!-- CHART -->
<div class="mt-10 bg-white rounded-2xl shadow-md p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">
        Grafik Peminjaman Bulanan ({{ now()->year }})
    </h2>

    <!-- HEIGHT WAJIB -->
    <div class="relative h-[320px]">
        <canvas id="peminjamanChart"></canvas>
    </div>
</div>

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
window.addEventListener('load', function () {

    const canvas = document.getElementById('peminjamanChart')
    if (!canvas) {
        console.error('Canvas peminjamanChart tidak ditemukan')
        return
    }

    const labels = @json($labels);
    const data = @json($formattedData);

    if (!Array.isArray(labels) || !Array.isArray(data)) {
        console.error('Data chart bukan array')
        return
    }

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: data,
                backgroundColor: 'rgba(20, 184, 166, 0.7)',
                hoverBackgroundColor: 'rgba(20, 184, 166, 1)',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#e5e7eb' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    })
})
</script>
@endpush
