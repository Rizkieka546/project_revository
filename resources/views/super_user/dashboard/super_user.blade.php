@extends('layouts.su')

@section('content')
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center">
                <div class="text-yellow-600 text-xl">
                    <i class="fas fa-box"></i> <!-- Ikon barang -->
                </div>
                <span class="bg-teal-400 text-white text-lg px-4 py-2 rounded">{{ $jumlahBarang }}</span>
            </div>
            <h1 class="mt-4 text-lg font-semibold text-gray-700">Jumlah Barang</h1>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center">
                <div class="text-green-700 text-xl">
                    <i class="fas fa-clipboard-list"></i> <!-- Ikon peminjaman -->
                </div>
                <span class="bg-teal-400 text-white text-lg px-4 py-2 rounded">{{ $jumlahPeminjaman }}</span>
            </div>
            <h1 class="mt-4 text-lg font-semibold text-gray-700">Jumlah Peminjaman</h1>
        </div>
    </div>

    <!-- Grafik -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Grafik Peminjaman Bulanan</h2>
        <canvas id="peminjamanChart"></canvas>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('peminjamanChart').getContext('2d');

            // Ambil data dari Laravel
            const labels = @json($labels);
            const dataPeminjaman = @json($formattedData);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: dataPeminjaman,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
