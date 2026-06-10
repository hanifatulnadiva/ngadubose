<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - NGADUBOSE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex">

    @include('components.sidebar')

    <div class="flex-grow flex flex-col justify-between min-w-0">
        
        <header class="bg-white border-b border-slate-100 px-8 py-4 flex justify-between items-center shadow-sm">
            <h2 class="text-base font-bold text-slate-700">Statistik Sistem</h2>
            <span class="text-xs text-slate-400 font-mono bg-slate-50 px-2 py-1 rounded">Hari ini: {{ date('d M Y') }}</span>
        </header>

        <main class="p-8 flex-grow space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Semua Laporan</span>
                        <span class="text-3xl font-black text-[#002B5B] mt-1 block">{{ $totalTickets }}</span>
                    </div>
                    <div class="bg-blue-50 text-[#002B5B] w-12 h-12 rounded-xl flex items-center justify-center text-xl shadow-sm">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Laporan Diproses</span>
                        <span class="text-3xl font-black text-blue-600 mt-1 block">{{ $statusDiproses }}</span>
                    </div>
                    <div class="bg-blue-50 text-blue-600 w-12 h-12 rounded-xl flex items-center justify-center text-xl shadow-sm">
                        <i class="fas fa-spinner animate-spin"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Laporan Selesai</span>
                        <span class="text-3xl font-black text-emerald-600 mt-1 block">{{ $statusSelesai }}</span>
                    </div>
                    <div class="bg-emerald-50 text-emerald-600 w-12 h-12 rounded-xl flex items-center justify-center text-xl shadow-sm">
                        <i class="fas fa-check-double"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-2 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-black text-slate-700 uppercase tracking-wide mb-1">Proporsi Status Penanganan</h3>
                        <p class="text-xs text-slate-400 mb-4">Persentase laporan berdasarkan status riil di sistem.</p>
                    </div>
                    <div class="w-full max-w-[240px] mx-auto py-2">
                        <canvas id="chartStatus"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-3 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-black text-slate-700 uppercase tracking-wide mb-1">Jumlah Kategori Pelanggaran</h3>
                        <p class="text-xs text-slate-400 mb-4">Grafik frekuensi aduan berdasarkan jenis topik pelanggaran.</p>
                    </div>
                    <div class="w-full h-full min-h-[240px]">
                        <canvas id="chartKategori"></canvas>
                    </div>
                </div>

            </div>
        </main>
        
    </div>

    <script>
        // 1. Inisialisasi Doughnut Chart (Status Laporan)
        const ctxStatus = document.getElementById('chartStatus').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut', 
            data: {
                labels: ['Diterima', 'Diverifikasi', 'Diproses', 'Selesai'],
                datasets: [{
                    data: [
                        {{ $statusDiterima }}, 
                        {{ $statusDiverifikasi }}, 
                        {{ $statusDiproses }}, 
                        {{ $statusSelesai }}
                    ],
                    backgroundColor: ['#F59E0B', '#A855F7', '#3B82F6', '#10B981'],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // 2. Inisialisasi Bar Chart (Kategori Pengaduan WBS)
        const ctxKategori = document.getElementById('chartKategori').getContext('2d');
        new Chart(ctxKategori, {
            type: 'bar', 
            data: {
                labels: ['Gratifikasi', 'Benturan Kepentingan', 'Korupsi', 'Pelanggaran Disiplin', 'Umum/Lainnya'],
                datasets: [{
                    label: 'Jumlah Aduan',
                    data: [
                        {{ $gratifikasi }}, 
                        {{ $benturanKepentingan }}, 
                        {{ $korupsi }}, 
                        {{ $pelanggaranAturan }}, 
                        {{ $lainnya }}
                    ],
                    backgroundColor: '#002B5B',
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 } 
                    }
                },
                plugins: {
                    legend: { display: false } 
                }
            }
        });
    </script>

</body>
</html>