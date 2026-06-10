<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketProgress;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TiketController extends Controller
{
    /**
     * Tampilan Halaman Utama (Dashboard/Statistik)
     */
    public function index()
    {
        $totalLaporan = Ticket::count();
        
        $laporanSelesai = TicketProgress::where('status', 'Selesai')->count();
        $laporanProses = TicketProgress::whereIn('status', ['Diverifikasi', 'Diproses'])->count();
        
        $persenSelesai = $totalLaporan > 0 ? round(($laporanSelesai / $totalLaporan) * 100) : 0;

        return view('home', compact('totalLaporan', 'laporanSelesai', 'laporanProses', 'persenSelesai'));
    }

    /**
     * Memproses Form Pengaduan dari USER PUBLIK (Tanpa Login)
     */
    public function storeReport(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'klasifikasi' => 'required',
            'jenis_pengaduan' => 'required',
            'uraian_kronologi' => 'required',
            'nama_terlapor' => 'required',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'bukti_pelaporan' => 'nullable|array|max:5',
            'bukti_pelaporan.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // 2. Generate Unique Ticket Code (WBS-2026-XXXXX)
        $tahun = date('Y');
        do {
            $ticketCode = 'WBS-' . $tahun . '-' . strtoupper(Str::random(5));
        } while (Ticket::where('ticket_code', $ticketCode)->exists());

        // 3. Handle File Upload (Multi File dikonversi ke JSON)
        $pathBukti = null;
        if ($request->hasFile('bukti_pelaporan')) {
            $paths = [];
            foreach ($request->file('bukti_pelaporan') as $file) {
                $paths[] = $file->store('bukti_pelaporan', 'public');
            }
            $pathBukti = json_encode($paths); 
        }

        // 4. Simpan Data Laporan Tiket ke Database
        $ticket = Ticket::create([
            'ticket_code' => $ticketCode,
            'klasifikasi' => $request->klasifikasi,
            'nama_pelapor' => $request->nama_pelapor ?? 'Anonim', 
            'jenis_pengaduan' => $request->jenis_pengaduan,
            'uraian_kronologi' => $request->uraian_kronologi,
            'nama_terlapor' => $request->nama_terlapor,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'bukti_pelaporan' => $pathBukti,
        ]);

        // 5. Simpan Progress Status Awal Laporan
        TicketProgress::create([
            'ticket_id' => $ticket->id,
            'status' => 'Diterima',
            'catatan_admin' => 'Laporan telah berhasil masuk ke sistem WBS BPS Kabupaten Bantul dan menunggu verifikasi tim pengawas.',
        ]);

        // =========================================================================
        // 6. DINAMIS: AMBIL NOMOR HP ADMIN DARI DATABASE SECARA OTOMATIS
        // =========================================================================
        try {
            $pesan_notifikasi = "🚨 *LAPORAN WBS BARU MASUK* 🚨\n\n"
                              . "Halo Admin NGADUBOSE, ada laporan pengaduan baru masuk dari Masyarakat (Publik).\n\n"
                              . "▪️ *Kode Tiket:* " . $ticketCode . "\n"
                              . "▪️ *Klasifikasi:* " . $request->klasifikasi . "\n"
                              . "▪️ *Jenis Pengaduan:* " . ucfirst(str_replace('_', ' ', $request->jenis_pengaduan)) . "\n"
                              . "▪️ *Tanggal Kejadian:* " . $request->tanggal_kejadian . "\n\n"
                              . "Silakan segera login ke Panel Dashboard Admin BPS Bantul untuk memeriksa berkas laporan. Terima kasih.";

            // Mengambil data admin berdasarkan kolom is_admin bernilai 1
            $admins = User::where('is_admin', 1)
                          ->whereNotNull('nomor_hp')
                          ->where('nomor_hp', '!=', '')
                          ->get();

            // Jalankan looping pengiriman pesan jika admin ditemukan di database
            foreach ($admins as $admin) {
                $this->kirimNotifikasiWA($admin->nomor_hp, $pesan_notifikasi);
            }

        } catch (\Exception $e) {
            Log::error('Gagal kirim WA ke Admin disebabkan: ' . $e->getMessage());
        }

        // 7. Alihkan ke halaman sukses dengan membawa kode tiket di session
        return redirect()->route('laporan.sukses')->with('kode_tiket', $ticketCode);
    }

    /**
     * Fungsi Pembantu Utama untuk Sinkronisasi API WhatsApp Gateway Fonnte
     */
    private function kirimNotifikasiWA($nomor_hp, $pesan)
    {
        $nomor_hp = str_replace([' ', '-', '+'], '', $nomor_hp);
        
        if (substr($nomor_hp, 0, 2) === '08') {
            $nomor_hp = '628' . substr($nomor_hp, 2);
        }

        $token = "EwV4DT2vY8dYYjdTMX8N"; 
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15, 
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $nomor_hp,
                'message' => $pesan,
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * Tampilan Halaman Sukses Kirim Laporan
     */
    public function sukses()
    {
        if (!session('kode_tiket')) {
            return redirect('/form-lapor'); 
        }

        return view('sukses-lapor');
    }

    /**
     * Manajemen Panel Admin: Mengubah Status Tahapan Progress Tiket Laporan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diterima,Diverifikasi,Diproses,Selesai',
            'komentar_bps' => 'nullable|string'
        ]);

        $ticket = Ticket::findOrFail($id);
        
        $ticket->progress()->create([
            'status' => $request->status,
            'catatan_admin' => $request->komentar_bps ?? 'Status diperbarui oleh admin.', 
        ]);

        $ticket->update([
            'komentar_bps' => $request->komentar_bps
        ]);
        
        return redirect()->back()->with('success', 'Status tiket berhasil diperbarui!');
    }

    /**
     * Publik Tracking: Lacak Status Pengaduan Berdasarkan Inputan Kode Tiket
     */
    public function lacakStatus(Request $request)
    {
        $ticketCode = $request->input('kode_tiket');

        if (!$ticketCode) {
            return view('lacak-status');
        }

        $ticket = Ticket::with(['progress' => function($query) {
            $query->latest();
        }])->where('ticket_code', $ticketCode)->first();

        if (!$ticket) {
            return view('lacak-status', [
                'ticketCode' => $ticketCode,
                'error' => 'Kode tiket yang Anda masukkan salah atau tidak terdaftar. Silakan coba lagi.'
            ]);
        }

        return view('lacak-status', [
            'ticketCode' => $ticketCode,
            'ticket' => $ticket
        ]);
    }
}