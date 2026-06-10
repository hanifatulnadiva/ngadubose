<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 h-screen flex overflow-hidden">

    @include('components.sidebar')

    <div class="flex-grow flex flex-col min-w-0 h-full overflow-y-auto">
        
        <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center sticky top-0 z-40 shadow-sm">
            <h2 class="text-sm font-bold text-slate-600">Dashboard / Manajemen User</h2>
            <div class="flex items-center gap-2">
                <span class="text-xs bg-slate-100 px-3 py-1.5 rounded-lg font-mono text-slate-500">Admin: {{ Auth::user()->name }}</span>
            </div>
        </header>

        <main class="p-8 flex-grow">
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Kelola Pengguna Admin</h1>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar akun administrator yang memiliki akses ke dashboard serta nomor WhatsApp untuk broadcast notifikasi.</p>
                </div>
                <button onclick="bukaModalTambah()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-blue-200 flex items-center gap-2 transition-all">
                    <i class="fas fa-user-plus text-sm"></i> Tambah Admin Baru
                </button>
            </div>

            @if(session('success'))
                <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
                    <i class="fas fa-check-circle text-emerald-500 text-base"></i> 
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-semibold shadow-sm">
                    <div class="flex items-center gap-2 mb-2 font-bold">
                        <i class="fas fa-exclamation-circle text-rose-500 text-base"></i>
                        <span>Terjadi Kesalahan Validasi:</span>
                    </div>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold border-b border-slate-200 tracking-wider">
                                <th class="p-4 pl-6 w-12 text-center">No</th>
                                <th class="p-4">Nama Lengkap</th>
                                <th class="p-4">Alamat Email</th>
                                <th class="p-4">Nomor HP / WhatsApp</th>
                                <th class="p-4">Status Hak Akses</th>
                                <th class="p-4 text-center pr-6 w-44">Aksi Kelola</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            @forelse($users as $index => $user)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="p-4 pl-6 text-center text-slate-400 font-mono">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="p-4 font-bold text-slate-800">
                                        {{ $user->name }}
                                    </td>
                                    <td class="p-4 text-slate-500 font-mono">
                                        {{ $user->email }}
                                    </td>
                                    <td class="p-4 text-slate-600">
                                        @if($user->nomor_hp)
                                            <span class="font-mono bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-[11px] border border-blue-100">
                                                <i class="fab fa-whatsapp text-emerald-500 mr-1"></i> {{ $user->nomor_hp }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        @if($user->is_admin == 1)
                                            <span class="bg-purple-50 text-purple-700 border border-purple-200 px-2.5 py-1 rounded-full text-[10px] font-bold">
                                                Super Admin
                                            </span>
                                        @else
                                            <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full text-[10px]">
                                                Regular User
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center pr-6 flex justify-center gap-2">
                                        <button onclick="bukaModalEdit({{ json_encode($user) }})" class="bg-amber-50 hover:bg-amber-100 text-amber-600 text-[11px] px-3 py-1.5 rounded-xl font-bold transition flex items-center gap-1 border border-amber-200">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        
                                        @if(Auth::id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user admin ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 text-[11px] px-3 py-1.5 rounded-xl font-bold transition flex items-center gap-1 border border-rose-200">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="bg-slate-100 text-slate-400 text-[11px] px-3 py-1.5 rounded-xl font-bold border border-slate-200 cursor-not-allowed italic" title="Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif">
                                                Aktif
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center text-slate-400 italic font-normal">
                                        <i class="fas fa-users-slash text-2xl mb-2 block text-slate-300"></i>
                                        Belum ada data user admin terdaftar di database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="py-4 text-center text-xs text-slate-400 bg-white border-t border-slate-200">
            &copy; {{ date('Y') }} NGADUBOSE — Whistleblowing System BPS Kabupaten Bantul.
        </footer>
    </div>

    <div id="userModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 transition-all duration-300 animate-fade-in">
        <div class="bg-white rounded-2xl w-[92%] max-w-md p-6 relative shadow-2xl flex flex-col border border-slate-100">
            
            <h3 id="modalTitle" class="text-base font-black text-slate-800 mb-5 flex items-center gap-2"></h3>
            
            <form id="userForm" method="POST" action="">
                @csrf
                <div id="methodField"></div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Admin <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="inputName" required placeholder="Contoh: Ahmad Subarjo, S.E." class="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 font-medium outline-none transition">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Alamat Email Resmi <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="inputEmail" required placeholder="name@bps.go.id" class="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 font-mono outline-none transition">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor HP / WhatsApp Utama <span class="text-rose-500">*</span></label>
                        <input type="text" name="nomor_hp" id="inputNomorHp" required placeholder="Contoh: 083896735071" class="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 font-mono outline-none transition">
                        <span class="text-[10px] text-slate-400 block mt-1">Sistem otomatis mengubah awalan 08xx menjadi kode internasional (628xx) saat broadcast WA.</span>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kata Sandi / Password <span id="pwdAsterisk" class="text-rose-500">*</span></label>
                        <input type="password" name="password" id="inputPassword" placeholder="••••••••" class="w-full p-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 outline-none transition">
                        <span id="pwdHint" class="text-[10px] text-slate-400 block mt-1 font-medium"></span>
                    </div>
                </div>

                <div class="flex justify-end gap-2 text-xs font-bold mt-6 pt-4 border-t border-slate-100">
                    <button type="button" onclick="tutupModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition shadow-md shadow-blue-100">
                        Simpan Data Admin
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('userModal');
        const form = document.getElementById('userForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');
        const pwdAsterisk = document.getElementById('pwdAsterisk');
        const pwdHint = document.getElementById('pwdHint');

        // Fungsi Membuka Modal Mode: Tambah Data User
        function bukaModalTambah() {
            modalTitle.innerHTML = '<i class="fas fa-user-plus text-blue-500 text-lg"></i> Tambah Akun Admin Baru';
            form.action = "{{ route('admin.users.store') }}"; 
            methodField.innerHTML = ''; // Kosongkan (Default browser POST)
            
            // Konfigurasi Input Password Wajib Diisi
            pwdAsterisk.classList.remove('hidden');
            pwdHint.innerText = 'Minimal panjang karakter password adalah 8 digit.';
            document.getElementById('inputPassword').required = true;
            
            // Reset Seluruh Input Form Menjadi Kosong
            document.getElementById('inputName').value = '';
            document.getElementById('inputEmail').value = '';
            document.getElementById('inputNomorHp').value = '';
            document.getElementById('inputPassword').value = '';

            modal.classList.remove('hidden');
        }

        // Fungsi Membuka Modal Mode: Edit / Update Data User
        function bukaModalEdit(user) {
            modalTitle.innerHTML = '<i class="fas fa-user-edit text-amber-500 text-lg"></i> Ubah Data Profil Admin';
            form.action = `/admin/users/${user.id}`; 
            
            // SOLUSI: Menggunakan tag input HTML tersembunyi agar dideteksi oleh route PUT Laravel
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">'; 
            
            // Konfigurasi Input Password Opsional
            pwdAsterisk.classList.add('hidden');
            pwdHint.innerText = 'Biarkan kolom ini kosong jika tidak ingin mengubah password akun.';
            document.getElementById('inputPassword').required = false;
            
            // Isi Form dengan Data User Terpilih dari Database
            document.getElementById('inputName').value = user.name;
            document.getElementById('inputEmail').value = user.email;
            document.getElementById('inputNomorHp').value = user.nomor_hp ?? '';
            document.getElementById('inputPassword').value = '';

            modal.classList.remove('hidden');
        }

        // Fungsi Menutup Modal Popup
        function tutupModal() {
            modal.classList.add('hidden');
        }

        // Menutup otomatis jika user mengklik area abu-abu di luar kotak modal
        window.onclick = function(event) {
            if (event.target == modal) {
                tutupModal();
            }
        }
    </script>
</body>
</html>