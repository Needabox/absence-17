@extends('user.layout')

@section('content')
<!-- SweetAlert2 CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.css">
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Flash Message with SweetAlert -->
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#10b981',
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
            </script>
        @endif

        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ strtoupper($kelas->name) }}</h1>
                        <p class="text-gray-500 text-lg" id="currentDate"></p>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Absen -->
        <form id="attendanceForm" method="POST" action="{{ route('absen.store') }}">
            @csrf

            <!-- Attendance Table Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="px-8 py-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900">Daftar Kehadiran</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 w-16">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama Siswa</th>
                                <th class="px-4 py-4 text-center text-sm font-semibold text-gray-900 w-24">
                                    <div class="flex flex-col items-center">
                                        <span class="text-emerald-600">Hadir</span>
                                        <div class="w-3 h-3 bg-emerald-500 rounded-full mt-1"></div>
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-sm font-semibold text-gray-900 w-24">
                                    <div class="flex flex-col items-center">
                                        <span class="text-yellow-600">Sakit</span>
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full mt-1"></div>
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-sm font-semibold text-gray-900 w-24">
                                    <div class="flex flex-col items-center">
                                        <span class="text-blue-600">Izin</span>
                                        <div class="w-3 h-3 bg-blue-500 rounded-full mt-1"></div>
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-sm font-semibold text-gray-900 w-24">
                                    <div class="flex flex-col items-center">
                                        <span class="text-red-600">Alpa</span>
                                        <div class="w-3 h-3 bg-red-500 rounded-full mt-1"></div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($students as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5">
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-600">{{ $index + 1 }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-medium text-gray-900">{{ $item->student->name }}</div>
                                    <input type="hidden" name="student_ids[]" value="{{ $item->student->id }}">
                                </td>
                                @foreach (['hadir', 'sakit', 'izin', 'alpa'] as $status)
                                    <td class="px-4 py-5 text-center">
                                        <div class="flex justify-center">
                                            <input type="radio" 
                                                   name="status_{{ $item->student->id }}" 
                                                   value="{{ $status }}"
                                                   class="w-5 h-5 text-{{ $status === 'hadir' ? 'emerald' : ($status === 'sakit' ? 'yellow' : ($status === 'izin' ? 'blue' : 'red')) }}-600 
                                                          border-2 border-gray-300 focus:ring-2 focus:ring-{{ $status === 'hadir' ? 'emerald' : ($status === 'sakit' ? 'yellow' : ($status === 'izin' ? 'blue' : 'red')) }}-500 
                                                          focus:ring-offset-2 transition-all duration-150"
                                                   required>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl p-6 border border-emerald-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-emerald-600 mb-1">Hadir</p>
                            <p class="text-3xl font-bold text-emerald-700" id="hadirCount">0</p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 border border-yellow-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-yellow-600 mb-1">Sakit</p>
                            <p class="text-3xl font-bold text-yellow-700" id="sakitCount">0</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 mb-1">Izin</p>
                            <p class="text-3xl font-bold text-blue-700" id="izinCount">0</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-6 border border-red-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-600 mb-1">Alpa</p>
                            <p class="text-3xl font-bold text-red-700" id="alpaCount">0</p>
                        </div>
                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit"
                        class="w-full inline-flex items-center px-8 py-4 text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 
                               focus:ring-4 focus:ring-blue-300 rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl 
                               transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Simpan Absen
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script>
    // Set current date
    const currentDate = new Date().toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    document.getElementById('currentDate').textContent = currentDate;

    // Update summary counts
    function updateSummary() {
        const statuses = ['hadir', 'sakit', 'izin', 'alpa'];
        
        statuses.forEach(status => {
            const count = document.querySelectorAll(`input[type="radio"][value="${status}"]:checked`).length;
            document.getElementById(`${status}Count`).textContent = count;
        });
    }

    // Add event listeners to all radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            updateSummary();
            
            // Add visual feedback
            this.closest('tr').classList.add('bg-blue-50');
            setTimeout(() => {
                this.closest('tr').classList.remove('bg-blue-50');
            }, 300);
        });
    });

    // Trigger summary update on load
    window.addEventListener('DOMContentLoaded', updateSummary);

    // Add form validation with SweetAlert
    document.getElementById('attendanceForm').addEventListener('submit', function(e) {
        const studentCount = document.querySelectorAll('input[name="student_ids[]"]').length;
        const checkedCount = document.querySelectorAll('input[type="radio"]:checked').length;
        
        if (checkedCount < studentCount) {
            e.preventDefault();
            
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Mohon lengkapi status kehadiran untuk semua siswa!',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3B82F6'
            });
            return false;
        }

        // Show loading when submitting
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
</script>
@endsection