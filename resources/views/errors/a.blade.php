<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Sistem Absensi Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-blue-200">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <h1 class="text-xl font-semibold text-blue-800">Sistem Absensi Sekolah</h1>
        </div>
    </header>

    <!-- Container untuk semua halaman error -->
    <main class="flex-1 flex items-center justify-center px-4 py-16">
        
        <!-- Halaman 404 -->
        <div id="page404" class="error-page text-center max-w-2xl mx-auto">
            <div class="text-8xl font-bold text-blue-600 mb-8">404</div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Halaman Tidak Ditemukan</h1>
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                Maaf, halaman yang Anda cari tidak dapat ditemukan dalam sistem absensi. 
                Silakan periksa kembali URL atau kembali ke halaman utama.
            </p>
            <button onclick="goHome()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition duration-200 shadow-lg hover:shadow-xl">
                Kembali ke Beranda
            </button>
        </div>

        <!-- Halaman 403 -->
        <div id="page403" class="error-page text-center max-w-2xl mx-auto hidden">
            <div class="text-8xl font-bold text-red-500 mb-8">403</div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Akses Ditolak</h1>
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                Anda tidak memiliki izin untuk mengakses halaman ini. 
                Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
            </p>
            <div class="space-x-4">
                <button onclick="contactAdmin()" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition duration-200 shadow-lg hover:shadow-xl">
                    Hubungi Admin
                </button>
                <button onclick="goHome()" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition duration-200 shadow-lg hover:shadow-xl">
                    Kembali ke Beranda
                </button>
            </div>
        </div>

        <!-- User Tidak Terdaftar -->
        <div id="pageNotRegistered" class="error-page text-center max-w-2xl mx-auto hidden">
            <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Belum Terdaftar di Kelas</h1>
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                Anda belum terdaftar di kelas manapun dalam sistem absensi. 
                Silakan hubungi administrator sekolah untuk mendaftarkan Anda ke kelas yang sesuai.
            </p>
            <div class="space-x-4">
                <button onclick="contactAdmin()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition duration-200 shadow-lg hover:shadow-xl">
                    Hubungi Admin
                </button>
                <button onclick="goHome()" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition duration-200 shadow-lg hover:shadow-xl">
                    Kembali ke Beranda
                </button>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-blue-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <p class="text-center text-gray-600">© 2025 Sistem Absensi Sekolah. All rights reserved.</p>
        </div>
    </footer>

    <!-- Navigation untuk demo -->
    <div class="fixed bottom-4 right-4">
        <div class="bg-white rounded-lg shadow-lg p-4 border border-blue-200">
            <p class="text-sm text-gray-600 mb-2 text-center font-medium">Demo Navigation</p>
            <div class="flex flex-col gap-2">
                <button onclick="showPage('page404')" class="bg-blue-100 text-blue-700 px-4 py-2 rounded text-sm hover:bg-blue-200 transition">
                    404 - Not Found
                </button>
                <button onclick="showPage('page403')" class="bg-red-100 text-red-700 px-4 py-2 rounded text-sm hover:bg-red-200 transition">
                    403 - Forbidden
                </button>
                <button onclick="showPage('pageNotRegistered')" class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded text-sm hover:bg-yellow-200 transition">
                    Not Registered
                </button>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan halaman tertentu
        function showPage(pageId) {
            // Sembunyikan semua halaman
            document.querySelectorAll('.error-page').forEach(page => {
                page.classList.add('hidden');
            });
            
            // Tampilkan halaman yang dipilih
            document.getElementById(pageId).classList.remove('hidden');
        }

        // Fungsi untuk kembali ke beranda
        function goHome() {
            alert('Mengarahkan ke halaman beranda...');
            // window.location.href = '/dashboard'; // Uncomment untuk implementasi nyata
        }

        // Fungsi untuk menghubungi admin
        function contactAdmin() {
            alert('Mengarahkan ke halaman kontak admin...');
            // window.location.href = '/contact-admin'; // Uncomment untuk implementasi nyata
        }

        // Auto-detect error type berdasarkan URL atau parameter
        function detectErrorType() {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            
            switch(error) {
                case '403':
                    showPage('page403');
                    break;
                case 'not-registered':
                    showPage('pageNotRegistered');
                    break;
                default:
                    showPage('page404');
            }
        }

        // Jalankan deteksi saat halaman dimuat
        // detectErrorType(); // Uncomment untuk auto-detect
    </script>

</body>
</html>