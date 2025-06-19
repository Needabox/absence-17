@extends('user.layout')

@section('content')
    <div class="max-w-6xl mx-auto mt-10 space-y-8 px-4">

        <!-- Success Message -->
        <div class="bg-white border border-green-300 rounded-lg shadow-md p-6 text-center">
            <h2 class="text-2xl font-bold text-green-600 mb-2">✅ Absensi Hari Ini Sudah Selesai</h2>
            <p class="text-gray-700 text-sm">
                Anda telah mengisi absensi untuk kelas <strong>{{ strtoupper($kelas->name) }}</strong> pada tanggal
                <strong>{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</strong>.
            </p>
        </div>

        <!-- Pie Chart -->
        <div class="flex justify-center">
            <div class="w-[200px] h-[200px]">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Absensi Bulan Ini</h3>
                <canvas id="absensiChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Tabel Top 5 -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Sakit -->
            <div class="bg-white border rounded-lg shadow-md p-4">
                <h4 class="text-md font-semibold text-yellow-600 mb-3">😷 Top 5 Sakit</h4>
                <table class="w-full text-sm text-left text-gray-700 border">
                    <thead class="bg-gray-100 text-gray-800">
                        <tr>
                            <th class="px-3 py-2 border">#</th>
                            <th class="px-3 py-2 border">Nama</th>
                            <th class="px-3 py-2 border text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topSakit as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-3 py-2 border">{{ $item->name }}</td>
                                <td class="px-3 py-2 border text-center">{{ $item->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Izin -->
            <div class="bg-white border rounded-lg shadow-md p-4">
                <h4 class="text-md font-semibold text-blue-600 mb-3">📘 Top 5 Izin</h4>
                <table class="w-full text-sm text-left text-gray-700 border">
                    <thead class="bg-gray-100 text-gray-800">
                        <tr>
                            <th class="px-3 py-2 border">#</th>
                            <th class="px-3 py-2 border">Nama</th>
                            <th class="px-3 py-2 border text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topIzin as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-3 py-2 border">{{ $item->name }}</td>
                                <td class="px-3 py-2 border text-center">{{ $item->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Alpa -->
            <div class="bg-white border rounded-lg shadow-md p-4">
                <h4 class="text-md font-semibold text-red-600 mb-3">🚫 Top 5 Alpa</h4>
                <table class="w-full text-sm text-left text-gray-700 border">
                    <thead class="bg-gray-100 text-gray-800">
                        <tr>
                            <th class="px-3 py-2 border">#</th>
                            <th class="px-3 py-2 border">Nama</th>
                            <th class="px-3 py-2 border text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topAlpa as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-3 py-2 border">{{ $item->name }}</td>
                                <td class="px-3 py-2 border text-center">{{ $item->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('absensiChart').getContext('2d');
        const absensiChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Hadir', 'Sakit', 'Izin', 'Alpa'],
                datasets: [{
                    data: [{{ $statistik['hadir'] }}, {{ $statistik['sakit'] }},
                        {{ $statistik['izin'] }}, {{ $statistik['alpa'] }}
                    ],
                    backgroundColor: ['#16a34a', '#facc15', '#3b82f6', '#ef4444'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
