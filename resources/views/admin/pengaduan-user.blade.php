<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - NGADUBOSE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 h-screen overflow-hidden flex">

    @include('components.sidebar')

    <div class="flex-grow flex flex-col justify-between min-w-0 h-full overflow-y-auto">
        
        <div>
            <header class="bg-white border-b border-slate-100 px-8 py-4 flex justify-between items-center shadow-sm sticky top-0 z-40">
                <h2 class="text-base font-bold text-slate-700">Laporan Pengaduan</h2>
                <span class="text-xs text-slate-400 font-mono bg-slate-50 px-2 py-1 rounded">Hari ini: {{ date('d M Y') }}</span>
            </header>

            <main class="p-8 flex-grow">
                
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-black text-[#002B5B]">Daftar Pengaduan/ Laporan Ngadubose</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Kelola, verifikasi, dan berikan tanggapan resmi pada laporan masuk.</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari data..." 
                                class="pl-9 pr-4 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none w-64 shadow-sm">
                        </div>
                        
                        <div class="bg-blue-50 text-[#002B5B] px-3 py-1.5 rounded-lg text-xs font-bold border border-blue-100">
                            Total: {{ $tickets->count() }} Laporan
                        </div>
                    </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm ...">
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
                        <i class="fas fa-check-circle text-emerald-500 text-base"></i> 
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold border-b border-slate-200 tracking-wider">
                                    <th class="p-4 pl-6">Kode Tiket</th>
                                    <th class="p-4">Tgl Masuk</th>       
                                    <th class="p-4">Tgl Kejadian</th>
                                    <th class="p-4">Klasifikasi</th>
                                    <th class="p-4">Nama Pelapor</th>
                                    <th class="p-4">Jenis & Terlapor</th>
                                    <th class="p-4">Uraian</th> 
                                    <th class="p-4">Bukti</th>
                                    <th class="p-4">Status Sekarang</th>
                                    <!-- <th class="p-4 text-center pr-6">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody id="ticketsTableBody" class="divide-y divide-slate-100">
                                @forelse($tickets as $t)
                                    <tr class="row-item hover:bg-slate-50/50 transition">
                                        <td class="p-4 pl-6 font-mono font-bold text-blue-700 text-xs">{{ $t->ticket_code }}</td>
                                        
                                        <td class="p-4 text-xs text-slate-600">{{ $t->created_at->format('d M Y') }}</td>
                                        
                                        <td class="p-4 text-xs text-slate-600">
                                            {{ $t->tanggal_kejadian ? \Carbon\Carbon::parse($t->tanggal_kejadian)->format('d M Y') : '-' }}
                                        </td>
                                        
                                        <td class="p-4">
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-blue-50 text-blue-700">
                                                {{ $t->klasifikasi ?? 'Pengaduan' }}
                                            </span>
                                        </td>
                                        
                                        <td class="p-4 font-semibold text-slate-700">
                                            {{ $t->nama_pelapor }}
                                        </td>
                                        
                                        <td class="p-4">
                                            <span class="block font-bold text-slate-800 uppercase text-[11px] tracking-wide">
                                                {{ str_replace('_', ' ', $t->jenis_pengaduan) }}
                                            </span>
                                            <span class="text-xs text-slate-400 block mt-0.5">
                                                Oleh oknum: <span class="text-slate-600 font-medium">{{ $t->nama_terlapor }}</span>
                                            </span>
                                        </td>
                                        
                                        <td class="p-4">
                                            <div class="max-w-xs text-xs text-slate-600 line-clamp-3">
                                                {{ $t->uraian_kronologi }}
                                            </div>
                                        </td>
                                        
                                        <td class="p-4">
                                            @if($t->bukti_pelaporan)
                                                @php
                                                    $buktiArray = is_array($t->bukti_pelaporan) ? $t->bukti_pelaporan : json_decode($t->bukti_pelaporan, true) ?? [$t->bukti_pelaporan];
                                                    $buktiUrls = array_map(function($path) { 
                                                        return asset('storage/' . trim($path)); 
                                                    }, $buktiArray);
                                                @endphp
                                                <button type="button"
                                                    onclick="openBuktiModal({{ json_encode($buktiUrls) }})"
                                                    class="text-xs text-blue-600 underline font-semibold hover:text-blue-800 flex items-center gap-1">
                                                    <i class="fas fa-images"></i> Lihat Bukti ({{ count($buktiUrls) }})
                                                </button>
                                            @else
                                                <span class="text-xs text-slate-400">Tidak ada bukti</span>
                                            @endif
                                        </td>

                                        <td class="p-4">
                                            <form id="form-status-{{ $t->id }}" action="{{ route('admin.tickets.update-status', $t->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                
                                                @php
                                                    $latestProgress = $t->progress->sortByDesc('id')->first();
                                                    $currentStatus = $latestProgress->status ?? 'Diterima';
                                                @endphp

                                                <!-- Ditambahkan input hidden untuk menampung catatan dari modal -->
                                                <input type="hidden" name="komentar_bps" id="catatan-{{ $t->id }}">

                                                <select name="status" 
                                                    data-current="{{ $currentStatus }}"
                                                    onchange="bukaModalKonfirmasiStatus(this, '{{ $t->id }}', '{{ $t->ticket_code }}')" 
                                                    class="text-xs font-bold rounded-full px-3 py-1.5 border border-transparent cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors
                                                    {{ $currentStatus == 'Selesai' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 
                                                      ($currentStatus == 'Diproses' ? 'bg-blue-50 text-blue-600 border-blue-200' : 
                                                      ($currentStatus == 'Diverifikasi' ? 'bg-purple-50 text-purple-600 border-purple-200' : 'bg-amber-50 text-amber-600 border-amber-200')) }}">
                                                    
                                                    <option value="Diterima" {{ $currentStatus == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                                    <option value="Diverifikasi" {{ $currentStatus == 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                                    <option value="Diproses" {{ $currentStatus == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="Selesai" {{ $currentStatus == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                </select>
                                            </form>
                                        </td>

                                        <!-- <td class="p-4 text-center pr-6">
                                            <button class="bg-[#002B5B] hover:bg-blue-900 text-white text-xs px-3 py-1.5 rounded-xl font-bold transition shadow-sm shadow-blue-900/10 flex items-center gap-1 mx-auto">
                                                <i class="fas fa-cog text-[10px]"></i> Kelola
                                            </button>
                                        </td> -->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="p-12 text-center text-slate-400 italic">
                                            <div class="text-4xl mb-2 text-slate-300"><i class="fas fa-folder-open"></i></div>
                                            Belum ada data laporan pengaduan masyarakat yang masuk.
                                        </td>
                                    </tr>
                                @endforelse
                                
                                <tr id="noResults" class="hidden">
                                    <td colspan="10" class="p-12 text-center text-slate-500 font-medium">
                                        <i class="fas fa-search-minus mr-2"></i> Data yang Anda cari tidak ditemukan.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

        <footer class="py-4 text-center text-xs text-slate-400 bg-white border-t border-slate-100">
            &copy; {{ date('Y') }} NGADUBOSE. All Rights Reserved.
        </footer>
    </div>

    <!-- MODAL 1: LIHAT BUKTI -->
    <div id="buktiModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 animate-fade-in">
        <div class="bg-white rounded-2xl w-[90%] max-w-2xl p-6 relative shadow-2xl flex flex-col max-h-[90vh]">
            <button onclick="closeBuktiModal()" class="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition z-10">
                <i class="fas fa-times-circle text-2xl"></i>
            </button>
            
            <h3 class="text-base font-bold text-slate-700 mb-4 flex items-center gap-2">
                <i class="fas fa-file-alt text-blue-500"></i> Lampiran Bukti Pelaporan
            </h3>

            <div class="flex-grow flex justify-center items-center bg-slate-50 p-4 rounded-xl border border-slate-100 overflow-hidden min-h-[250px]">
                <img id="mainBukti" src="" class="max-h-[50vh] w-auto rounded-lg shadow-sm object-contain hidden">
                
                <div id="linkDokumen" class="hidden py-8 text-center">
                    <i class="fas fa-file-pdf text-5xl text-red-500 mb-3 block"></i>
                    <p class="text-sm text-slate-600 mb-4">Dokumen tidak dapat dipreview langsung.</p>
                    <a id="downloadBtn" href="" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg font-bold transition inline-flex items-center gap-1">
                        <i class="fas fa-external-link-alt"></i> Buka / Download Dokumen
                    </a>
                </div>
            </div>

            <div id="thumbnailContainer" class="mt-4 flex flex-wrap gap-2 justify-center max-h-[100px] overflow-y-auto py-1 hidden"></div>
        </div>
    </div>

    <!-- MODAL 2: KONFIRMASI STATUS & CATATAN ADMIN (BARU) -->
    <div id="konfirmasiStatusModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl w-[90%] max-w-md p-6 relative shadow-2xl flex flex-col animate-fade-in">
            <h3 class="text-base font-bold text-slate-800 mb-2 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-amber-500"></i> Konfirmasi Perubahan Status
            </h3>
            
            <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                Apakah Anda yakin ingin mengubah status tiket <span id="modalTicketCode" class="font-mono font-bold text-blue-700"></span> menjadi <span id="modalStatusBaru" class="px-2 py-0.5 text-[11px] font-black rounded bg-slate-100 text-slate-700"></span>?
            </p>

            <div class="mb-5">
                <label for="modalCatatan" class="block text-xs font-bold text-slate-700 mb-1.5">Catatan Admin / Tindak Lanjut:</label>
                <textarea id="modalCatatan" rows="3" class="w-full text-xs p-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 placeholder-slate-400" placeholder="Tulis alasan perubahan status atau catatan tindak lanjut di sini..."></textarea>
            </div>

            <div class="flex justify-end gap-2 text-xs font-bold">
                <button type="button" onclick="batalKonfirmasiStatus()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition">
                    Batal
                </button>
                <button type="button" onclick="submitKonfirmasiStatus()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition shadow-sm">
                    Simpan & Ubah Status
                </button>
            </div>
        </div>
    </div>

    <script>
    let currentSelectElement = null;
    let currentTicketId = null;
    let currentTargetStatus = '';

    function bukaModalKonfirmasiStatus(selectElement, ticketId, ticketCode) {
        currentSelectElement = selectElement;
        currentTicketId = ticketId;
        currentTargetStatus = selectElement.value;

        // Set info teks di dalam modal
        document.getElementById('modalTicketCode').innerText = ticketCode;
        document.getElementById('modalStatusBaru').innerText = currentTargetStatus;
        document.getElementById('modalCatatan').value = ''; // Reset isi textarea

        // Tampilkan modal
        document.getElementById('konfirmasiStatusModal').classList.remove('hidden');
    }

    function batalKonfirmasiStatus() {
        // Kembalikan value select ke status lama (data-current) jika dibatalkan
        if (currentSelectElement) {
            currentSelectElement.value = currentSelectElement.getAttribute('data-current');
        }
        document.getElementById('konfirmasiStatusModal').classList.add('hidden');
    }

    function submitKonfirmasiStatus() {
        const catatanText = document.getElementById('modalCatatan').value;
        
        // Pindahkan catatan dari textarea modal ke input hidden form terkait
        document.getElementById(`catatan-${currentTicketId}`).value = catatanText;
        
        // Submit form
        document.getElementById(`form-status-${currentTicketId}`).submit();
    }

    // --- SCRIPT MODAL BUKTI (BAWAAN SEBELUMNYA) ---
    let currentActiveFiles = [];

    function openBuktiModal(fileUrls) {
        currentActiveFiles = Array.isArray(fileUrls) ? fileUrls : [fileUrls];
        if (currentActiveFiles.length === 0) return;

        switchActiveModalFile(currentActiveFiles[0]);

        const thumbContainer = document.getElementById('thumbnailContainer');
        thumbContainer.innerHTML = '';

        if (currentActiveFiles.length > 1) {
            thumbContainer.classList.remove('hidden');

            currentActiveFiles.forEach((url, index) => {
                const ext = url.split('.').pop().toLowerCase();
                const isImg = ['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(ext);

                const thumbButton = document.createElement('button');
                thumbButton.type = 'button';
                thumbButton.className = `w-14 h-14 rounded-lg border-2 transition overflow-hidden bg-slate-100 flex items-center justify-center text-[10px] font-bold ${index === 0 ? 'border-blue-500 scale-105 shadow-sm' : 'border-transparent opacity-60 hover:opacity-100'}`;
                thumbButton.id = `modal-thumb-${index}`;

                if (isImg) {
                    thumbButton.innerHTML = `<img src="${url}" class="w-full h-full object-cover">`;
                } else {
                    thumbButton.innerHTML = `<i class="fas fa-file-pdf text-red-500 text-lg"></i>`;
                }

                thumbButton.onclick = function() {
                    switchActiveModalFile(url);

                    currentActiveFiles.forEach((_, idx) => {
                        const btn = document.getElementById(`modal-thumb-${idx}`);
                        if (btn) btn.className = `w-14 h-14 rounded-lg border-2 transition overflow-hidden bg-slate-100 flex items-center justify-center border-transparent opacity-60`;
                    });

                    thumbButton.className = `w-14 h-14 rounded-lg border-2 transition overflow-hidden bg-slate-100 flex items-center justify-center border-blue-500 scale-105 shadow-sm`;
                };

                thumbContainer.appendChild(thumbButton);
            });
        } else {
            thumbContainer.classList.add('hidden');
        }

        document.getElementById('buktiModal').classList.remove('hidden');
    }

    function switchActiveModalFile(fileUrl) {
        const imgElement = document.getElementById('mainBukti');
        const docElement = document.getElementById('linkDokumen');
        const downloadBtn = document.getElementById('downloadBtn');

        imgElement.classList.add('hidden');
        docElement.classList.add('hidden');

        const extension = fileUrl.split('.').pop().toLowerCase();

        if (['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(extension)) {
            imgElement.src = fileUrl;
            imgElement.classList.remove('hidden');
        } else {
            downloadBtn.href = fileUrl;
            docElement.classList.remove('hidden');
        }
    }

    function closeBuktiModal() {
        document.getElementById('buktiModal').classList.add('hidden');
    }

    // Close modal if click outside
    window.onclick = function(event) {
        const buktiModal = document.getElementById('buktiModal');
        const statusModal = document.getElementById('konfirmasiStatusModal');
        
        if (event.target == buktiModal) {
            closeBuktiModal();
        }
        if (event.target == statusModal) {
            batalKonfirmasiStatus();
        }
    }
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const tableBody = document.getElementById("ticketsTableBody");
        const rows = tableBody.getElementsByClassName("row-item");
        const noResults = document.getElementById("noResults");
        
        let found = false;

        for (let i = 0; i < rows.length; i++) {
            const rowText = rows[i].textContent || rows[i].innerText;
            if (rowText.toLowerCase().indexOf(filter) > -1) {
                rows[i].style.display = "";
                found = true; 
            } else {
                rows[i].style.display = "none";
            }
        }

        if (found) {
            noResults.classList.add("hidden");
        } else {
            noResults.classList.remove("hidden");
        }
    }
    </script>
</body>
</html>