<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngadubose - Whistleblowing System BPS Kabupaten Bantul</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-32px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans">
    @include('components.navbar')

    <!-- Hero -->
    <section class="max-w-5xl mx-auto px-6 pt-24 pb-16 text-center">
        <div class="reveal">
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight">
                Apa itu Ngadubose?
            </h1>
            <p class="text-orange-500 font-bold text-base md:text-lg mt-4 tracking-wide uppercase">
                Whistleblowing System Resmi BPS Kabupaten Bantul
            </p>
            <p class="max-w-3xl mx-auto text-slate-600 text-base md:text-lg mt-4 leading-relaxed">
                Ngadubose adalah platform <strong>Whistle Blowing System (WBS)</strong> milik BPS Kabupaten Bantul
                untuk melaporkan dugaan pelanggaran, gratifikasi, atau pelayanan buruk dari pegawai BPS Bantul.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-10">
                <a href="{{ url('/form-lapor') }}"
                    class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-8 py-4 rounded-xl transition shadow-lg shadow-emerald-100">
                    <i class="fas fa-file-signature"></i>
                    Buat Laporan Baru
                </a>
                <a href="#lacak-status"
                    class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-8 py-4 rounded-xl transition shadow-sm">
                    <i class="fas fa-search text-slate-400"></i>
                    Lacak Laporan
                </a>
            </div>
        </div>
    </section>

    <!-- Alur -->
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="text-center mb-12 reveal">
            <h2 class="text-3xl font-extrabold text-slate-900">Alur Penanganan Laporan</h2>
            <p class="text-slate-500 mt-2">Berikut adalah langkah-langkah penanganan laporan Anda setiap tahapnya.</p>
        </div>
        <div class="relative grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="reveal [transition-delay:0.1s] relative flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4 text-blue-600 text-3xl">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h4 class="font-bold text-slate-800">Kirim Laporan</h4>
                <p class="text-sm text-slate-500 mt-2">Isi form dengan lengkap dan benar.</p>
                <div class="hidden md:block absolute top-10 -right-6 text-slate-300">
                    <i class="fas fa-arrow-right text-2xl"></i>
                </div>
            </div>
            <div class="reveal [transition-delay:0.2s] relative flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4 text-blue-600 text-3xl">
                    <i class="fas fa-search"></i>
                </div>
                <h4 class="font-bold text-slate-800">Verifikasi Internal</h4>
                <p class="text-sm text-slate-500 mt-2">Tim akan meninjau laporan Anda.</p>
                <div class="hidden md:block absolute top-10 -right-6 text-slate-300">
                    <i class="fas fa-arrow-right text-2xl"></i>
                </div>
            </div>
            <div class="reveal [transition-delay:0.3s] relative flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4 text-blue-600 text-3xl">
                    <i class="fas fa-cog"></i>
                </div>
                <h4 class="font-bold text-slate-800">Proses Tindak Lanjut</h4>
                <p class="text-sm text-slate-500 mt-2">Laporan sedang diproses dan ditindaklanjuti.</p>
                <div class="hidden md:block absolute top-10 -right-6 text-slate-300">
                    <i class="fas fa-arrow-right text-2xl"></i>
                </div>
            </div>
            <div class="reveal [transition-delay:0.4s] flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mb-4 text-emerald-600 text-3xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h4 class="font-bold text-slate-800">Umpan Balik Selesai</h4>
                <p class="text-sm text-slate-500 mt-2">Status laporan diberikan dan selesai.</p>
            </div>
        </div>
    </section>

    <!-- Nilai-Nilai -->
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="text-center mb-12 reveal">
            <h2 class="text-3xl font-extrabold text-slate-900">Nilai-Nilai Kami</h2>
            <p class="text-slate-500 mt-2">Prinsip utama dalam pengelolaan pengaduan di BPS Kabupaten Bantul.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="reveal [transition-delay:0.1s] bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-3">Transparansi</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Kami menjamin keterbukaan informasi dalam setiap alur penanganan laporan masyarakat.</p>
            </div>
            <div class="reveal [transition-delay:0.2s] bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-3">Akuntabilitas</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Setiap laporan diproses secara profesional dan dapat dilacak progresnya secara <em>real-time</em>.</p>
            </div>
            <div class="reveal [transition-delay:0.3s] bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-3">Partisipasi</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Mendorong peran aktif masyarakat dalam menjaga integritas BPS Kabupaten Bantul.</p>
            </div>
            <div class="reveal [transition-delay:0.4s] bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-3">Kepedulian</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Mengutamakan respon cepat dan empati atas setiap masukan yang diberikan masyarakat.</p>
            </div>
        </div>
    </section>

    <!-- Tentang -->
    <section id="tentang" class="max-w-7xl mx-auto px-6 py-16 border-t border-slate-100">
        <div class="grid md:grid-cols-2 gap-12 items-start">
            <div class="reveal-left bg-white p-8 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-emerald-600">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">Tentang Ngadubose</h2>
                <p class="text-slate-600 leading-relaxed mb-4">
                    Sistem ini dibangun untuk mendukung pembangunan Zona Integritas menuju Wilayah Bebas dari Korupsi (WBK)
                    dan Wilayah Birokrasi Bersih dan Melayani (WBBM) dengan menjamin
                    <strong>kerahasiaan pelapor 100%</strong>.
                </p>
            </div>
        </div>
    </section>

    <x-footer />

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.reveal, .reveal-left').forEach(el => observer.observe(el));
    </script>
</body>
</html>