<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Siswa</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">KELAS XI RPL 21</h1>
            <p class="text-gray-600">Tanggal: <span id="currentDate"></span></p>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <!-- Table Header -->
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 w-1/2">
                            DAFTAR SISWA
                        </th>
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-900 w-1/8">
                            HADIR
                        </th>
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-900 w-1/8">
                            SAKIT
                        </th>
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-900 w-1/8">
                            IZIN
                        </th>
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-900 w-1/8">
                            ALPA
                        </th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody class="divide-y divide-gray-200">
                    <!-- Student 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            1. Dafa Fairuz
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_1" value="hadir" class="w-4 h-4 text-green-600 focus:ring-green-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_1" value="sakit" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_1" value="izin" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_1" value="alpa" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        </td>
                    </tr>

                    <!-- Student 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            2. Mamat Suryanto
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_2" value="hadir" class="w-4 h-4 text-green-600 focus:ring-green-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_2" value="sakit" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_2" value="izin" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_2" value="alpa" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        </td>
                    </tr>

                    <!-- Student 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            3. Ahmad Rizki Pratama
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_3" value="hadir" class="w-4 h-4 text-green-600 focus:ring-green-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_3" value="sakit" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_3" value="izin" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_3" value="alpa" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        </td>
                    </tr>

                    <!-- Student 4 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            4. Siti Nurhaliza
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_4" value="hadir" class="w-4 h-4 text-green-600 focus:ring-green-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_4" value="sakit" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_4" value="izin" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_4" value="alpa" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        </td>
                    </tr>

                    <!-- Student 5 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            5. Budi Santoso
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_5" value="hadir" class="w-4 h-4 text-green-600 focus:ring-green-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_5" value="sakit" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_5" value="izin" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_5" value="alpa" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        </td>
                    </tr>

                    <!-- Student 6 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            6. Dewi Lestari
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_6" value="hadir" class="w-4 h-4 text-green-600 focus:ring-green-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_6" value="sakit" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_6" value="izin" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_6" value="alpa" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        </td>
                    </tr>

                    <!-- Student 7 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            7. Eko Prasetyo
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_7" value="hadir" class="w-4 h-4 text-green-600 focus:ring-green-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_7" value="sakit" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_7" value="izin" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_7" value="alpa" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        </td>
                    </tr>

                    <!-- Student 8 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            8. Fatimah Azzahra
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_8" value="hadir" class="w-4 h-4 text-green-600 focus:ring-green-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_8" value="sakit" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_8" value="izin" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-4 text-center">
                            <input type="radio" name="student_8" value="alpa" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Absen</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600" id="hadirCount">0</div>
                    <div class="text-sm text-green-600">Hadir</div>
                </div>
                <div class="text-center p-3 bg-yellow-50 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600" id="sakitCount">0</div>
                    <div class="text-sm text-yellow-600">Sakit</div>
                </div>
                <div class="text-center p-3 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600" id="izinCount">0</div>
                    <div class="text-sm text-blue-600">Izin</div>
                </div>
                <div class="text-center p-3 bg-red-50 rounded-lg">
                    <div class="text-2xl font-bold text-red-600" id="alpaCount">0</div>
                    <div class="text-sm text-red-600">Alpa</div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 text-center">
            <button type="button" onclick="submitAttendance()" class="bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg text-sm px-8 py-3 focus:ring-4 focus:ring-blue-300 transition-colors">
                Simpan Absen
            </button>
        </div>
    </div>

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
            const counts = {};
            
            statuses.forEach(status => {
                counts[status] = document.querySelectorAll(`input[type="radio"][value="${status}"]:checked`).length;
                document.getElementById(`${status}Count`).textContent = counts[status];
            });
        }

        // Add event listeners to all radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', updateSummary);
        });

        // Handle form submission
        function submitAttendance() {
            const attendance = {};
            const students = [];
            
            // Collect all attendance data
            for (let i = 1; i <= 8; i++) {
                const selectedRadio = document.querySelector(`input[name="student_${i}"]:checked`);
                if (selectedRadio) {
                    const studentName = document.querySelector(`tbody tr:nth-child(${i}) td:first-child`).textContent.trim();
                    students.push({
                        student: studentName,
                        status: selectedRadio.value
                    });
                }
            }
            
            if (students.length === 0) {
                alert('Mohon pilih status kehadiran untuk minimal satu siswa!');
                return;
            }
            
            // Show success message
            alert(`Absen berhasil disimpan untuk ${students.length} siswa!`);
            console.log('Data Absen:', students);
        }
    </script>
</body>
</html>