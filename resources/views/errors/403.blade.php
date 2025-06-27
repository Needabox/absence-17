<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col">

    <main class="flex-1 flex items-center justify-center px-4 py-16">
        <div class="text-center max-w-2xl mx-auto">
            <div class="text-8xl font-bold text-red-500 mb-8">403</div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Akses Ditolak</h1>
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                Anda tidak memiliki izin untuk mengakses halaman ini. 
                Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
            </p>
            <div class="space-x-4">
                <button onclick="contactAdmin()" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg text-lg font-medium shadow-lg">
                    Hubungi Admin
                </button>
                <button onclick="goHome()" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg text-lg font-medium shadow-lg">
                    Kembali ke Beranda
                </button>
            </div>
        </div>
    </main>
</body>
</html>
