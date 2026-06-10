<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGADUBOSE - Buat Laporan Pengaduan Baru</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#F0F7FF] text-slate-800 font-sans min-h-screen flex flex-col justify-between">

    @include('components.navbar')

    <main class="max-w-4xl w-full mx-auto px-6 py-12 flex-grow">
        
        @if(session('sukses'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-emerald-800 text-sm font-medium shadow-sm flex items-start gap-3">
                <i class="fas fa-check-circle text-emerald-600 mt-0.5 text-lg"></i>
                <div>
                    <p class="font-bold">Berhasil Terkirim!</p>
                    <p class="text-xs text-emerald-700 mt-0.5">{{ session('sukses') }}</p>
                    <a href="{{ url('/lacak-status') }}" class="text-xs text-emerald-600 underline font-semibold mt-2 inline-block hover:text-emerald-800">
                        Lacak Status Progres Laporan Anda &rarr;
                    </a>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-[#002B5B] p-6 text-white text-center">
                <h2 class="text-xl font-bold">Formulir Layanan Whistleblowing System</h2>
                <p class="text-xs text-blue-200 mt-1">Sampaikan laporan, aspirasi, atau saran Anda secara valid, aman, dan rahasia.</p>
            </div>

            <form action="{{ url('/kirim-laporan') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Klasifikasi Layanan <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="border-2 border-slate-200 rounded-xl p-4 flex items-start gap-3 cursor-pointer hover:border-[#002B5B] transition relative">
                            <input type="radio" name="klasifikasi" value="Pengaduan" checked class="mt-1 accent-[#002B5B]">
                            <div>
                                <span class="block text-sm font-bold text-slate-800">Pengaduan</span>
                                <span class="block text-[11px] text-slate-500 leading-tight mt-0.5">Laporan dugaan pelanggaran hukum/disiplin pegawai BPS Bantul.</span>
                            </div>
                        </label>

                        <label class="border-2 border-slate-200 rounded-xl p-4 flex items-start gap-3 cursor-pointer hover:border-[#002B5B] transition relative">
                            <input type="radio" name="klasifikasi" value="Aspirasi" class="mt-1 accent-[#002B5B]">
                            <div>
                                <span class="block text-sm font-bold text-slate-800">Aspirasi</span>
                                <span class="block text-[11px] text-slate-500 leading-tight mt-0.5">Ide, harapan, atau masukan demi kemajuan organisasi BPS Bantul.</span>
                            </div>
                        </label>

                        <label class="border-2 border-slate-200 rounded-xl p-4 flex items-start gap-3 cursor-pointer hover:border-[#002B5B] transition relative">
                            <input type="radio" name="klasifikasi" value="Informasi / Saran" class="mt-1 accent-[#002B5B]">
                            <div>
                                <span class="block text-sm font-bold text-slate-800">Informasi / Saran</span>
                                <span class="block text-[11px] text-slate-500 leading-tight mt-0.5">Permintaan info umum atau saran perbaikan pelayanan publik.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <hr class="border-slate-100">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Pelapor</label>
                        <input type="text" name="nama_pelapor" placeholder="Kosongkan jika ingin Anonim" class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-[#002B5B]">
                        <span class="text-[11px] text-gray-400 mt-1 block">Identitas Anda dijamin aman & rahasia 100% oleh sistem.</span>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Terlapor / Oknum <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_terlapor" required placeholder="Nama pegawai BPS yang dilaporkan" class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-[#002B5B]">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Pengaduan / Topik Laporan <span class="text-red-500">*</span></label>
                        <select name="jenis_pengaduan" required class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-[#002B5B]">
                            <option value="">-- Pilih Jenis Pengaduan --</option>
                            <option value="gratifikasi">Gratifikasi / Kasus Suap</option>
                            <option value="benturan_kepentingan">Benturan Kepentingan (Conflict of Interest)</option>
                            <option value="korupsi">Tindak Pidana Korupsi</option>
                            <option value="pelanggaran_aturan">Pelanggaran Aturan / Disiplin Kerja</option>
                            <option value="lainnya">Lainnya / Masalah Umum</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Kejadian <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kejadian" max="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-[#002B5B]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Uraian Kronologi Kejadian <span class="text-red-500">*</span></label>
                    <textarea name="uraian_kronologi" rows="5" required placeholder="Ceritakan secara mendetail runtutan kejadian, lokasi spesifik, waktu, dan kronologi dugaan pelanggaran..." class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-[#002B5B] leading-relaxed"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Bukti Pendukung
                    </label>

                    <div class="border border-slate-200 rounded-xl p-5 bg-slate-50">
                        <input
                            
                            type="file"
                            name="bukti_pelaporan[]"
                            accept=".jpg,.jpeg,.png,.pdf"
                            multiple
                            class="block w-full text-sm text-slate-700
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:bg-[#002B5B] file:text-white
                                hover:file:bg-[#003b7a]"
                        >
                        <div id="preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-5 gap-3"></div>

                        <p class="text-xs text-gray-500 mt-2">
                            Maksimal 5 file (JPG, JPEG, PNG, PDF)
                        </p>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="check-human" required class="w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 accent-emerald-600 cursor-pointer">
                        <label for="check-human" class="text-sm font-semibold text-slate-700 cursor-pointer select-none">
                            Saya menyatakan bahwa saya adalah manusia dan laporan ini dibuat dengan sebenar-benarnya
                        </label>
                    </div>
                    <div class="text-slate-300 text-xl hidden sm:block">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
                

                <div class="pt-2">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-md shadow-emerald-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                        Kirim Pengaduan Ke Sistem
                    </button>
                </div>

            </form>
        </div>
    </main>

    @include('components.footer')
    <script>
        const input = document.querySelector('input[name="bukti_pelaporan[]"]');
        const previewContainer = document.getElementById('preview-container');

        let selectedFiles = [];

        input.addEventListener('change', function () {

            const files = Array.from(this.files);

            // gabungkan file lama + baru
            selectedFiles = selectedFiles.concat(files);

            // max 5 file
            if (selectedFiles.length > 5) {
                alert('Maksimal 5 file');
                selectedFiles = selectedFiles.slice(0, 5);
            }

            renderPreview();

            // update input file (biar tetap sinkron)
            updateInputFiles();
        });

        function renderPreview() {
            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {

                const reader = new FileReader();

                reader.onload = function (e) {

                    let html = `
                        <div class="relative border rounded-lg overflow-hidden">
                            <img src="${e.target.result}" class="w-full h-24 object-cover">

                            <button type="button"
                                onclick="removeFile(${index})"
                                class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 rounded">
                                X
                            </button>
                        </div>
                    `;

                    previewContainer.innerHTML += html;
                };

                reader.readAsDataURL(file);
            });
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            renderPreview();
            updateInputFiles();
        }

        function updateInputFiles() {
            const dataTransfer = new DataTransfer();

            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });

            input.files = dataTransfer.files;
        }
    </script>
</body>
</html>