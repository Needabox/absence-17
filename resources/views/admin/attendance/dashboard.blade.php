@extends('admin.layouts.app')
@section('content')
    <div class="p-4 sm:ml-64 dark:bg-gray-900 bg-white mt-5">
        <h2 class="text-xl font-semibold mt-10 mb-4 text-gray-900 dark:text-white">Grafik Absensi {{ $year ?? date('Y') }}</h2>
        
        <!-- Chart Container -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg border border-gray-200 dark:border-gray-700 mb-4">
            <div style="position: relative; height: 400px; width: 100%;">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- Table -->
        <div class="p-4 border border-gray-200 rounded-lg dark:border-gray-700 dark:bg-gray-900 bg-white mt-3">
            <table id="selection-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">
                            <span class="flex items-center">
                                Name
                                <svg class="w-4 h-4 ms-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="px-6 py-3">
                            <span class="flex items-center">
                                Status Absensi
                            </span>
                        </th>
                        <th class="px-6 py-3">
                            <span class="flex items-center">
                                Action
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classes as $class)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $class->name }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($class->attendance_status === 'Sudah Absen')
                                    <span class="inline-block px-3 py-1 text-sm font-semibold text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-white">
                                        Sudah Absen
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 text-sm font-semibold text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-white">
                                        Belum Absen
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    @if ($class->attendance_status === 'Sudah Absen')
                                        <a href="#" class="text-blue-700 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 20 20">
                                                <path d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
                                                <path d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                                            </svg>
                                        </a>
                                    @else
                                        <button type="button" onclick="showNotAvailableAlert('{{ $class->name }}')" class="text-blue-700 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 20 20">
                                                <path d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
                                                <path d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada data kelas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function showNotAvailableAlert(className) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Download',
                text: 'Kelas ' + className + ' belum absen, data tidak dapat didownload!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }

        // Chart Script
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing chart...');
            
            // Data dari controller
            const chartLabels = @json($labels);
            const chartData = @json($chartData);
            
            console.log('Chart Labels:', chartLabels);
            console.log('Chart Data:', chartData);
            
            // Validasi data
            if (!chartLabels || !chartData) {
                console.error('Chart data or labels is missing');
                document.getElementById('attendanceChart').parentElement.innerHTML = 
                    '<p class="text-center text-red-500">Error: Data chart tidak tersedia</p>';
                return;
            }
            
            if (Object.keys(chartData).length === 0) {
                console.error('Chart data is empty');
                document.getElementById('attendanceChart').parentElement.innerHTML = 
                    '<p class="text-center text-gray-500">Belum ada data absensi untuk tahun ini</p>';
                return;
            }

            // Konfigurasi warna
            const colors = {
                'Hadir': {
                    background: 'rgba(34, 197, 94, 0.2)',
                    border: 'rgb(34, 197, 94)'
                },
                'Sakit': {
                    background: 'rgba(251, 191, 36, 0.2)',
                    border: 'rgb(251, 191, 36)'
                },
                'Izin': {
                    background: 'rgba(59, 130, 246, 0.2)',
                    border: 'rgb(59, 130, 246)'
                },
                'Alpa': {
                    background: 'rgba(239, 68, 68, 0.2)',
                    border: 'rgb(239, 68, 68)'
                }
            };

            // Buat datasets
            const datasets = [];
            Object.keys(chartData).forEach(status => {
                const color = colors[status] || {
                    background: 'rgba(128, 128, 128, 0.2)',
                    border: 'rgb(128, 128, 128)'
                };
                
                datasets.push({
                    label: status,
                    data: chartData[status],
                    borderColor: color.border,
                    backgroundColor: color.background,
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: color.border,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                });
            });
            
            console.log('Datasets:', datasets);

            // Dapatkan canvas element
            const ctx = document.getElementById('attendanceChart');
            if (!ctx) {
                console.error('Canvas element not found');
                return;
            }

            // Buat chart
            try {
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Grafik Absensi {{ $year ?? date('Y') }}',
                                font: {
                                    size: 18,
                                    weight: 'bold'
                                },
                                padding: 20
                            },
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Siswa',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                },
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    }
                                },
                                grid: {
                                    display: true,
                                    color: 'rgba(0, 0, 0, 0.1)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        hover: {
                            animationDuration: 200
                        }
                    }
                });
                
                console.log('Chart created successfully:', chart);
                
            } catch (error) {
                console.error('Error creating chart:', error);
                document.getElementById('attendanceChart').parentElement.innerHTML = 
                    '<p class="text-center text-red-500">Error: Gagal membuat chart - ' + error.message + '</p>';
            }
        });
    </script>
@endpush