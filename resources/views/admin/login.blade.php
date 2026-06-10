<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - NGADUBOSE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#F0F7FF] min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="bg-[#002B5B] p-6 text-white text-center">
            <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-user-shield text-xl text-blue-300"></i>
            </div>
            <h1 class="text-xl font-black tracking-wider uppercase">Panel Admin</h1>
            <p class="text-xs text-blue-200 mt-1">Whistleblowing System (WBS) Internal</p>
        </div>

        <form action="{{ url('/admin/login') }}" method="POST" class="p-6 space-y-4">
            @csrf

            @if($errors->has('login_error'))
                <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded-lg text-red-700 text-xs font-semibold flex items-start gap-2">
                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                    <span>{{ $errors->first('login_error') }}</span>
                </div>
            @endif

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Email Administrator</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fas fa-envelope text-sm"></i>
                    </span>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        placeholder="Masukkan email resmi admin" 
                        class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fas fa-lock text-sm"></i>
                    </span>
                    <input type="password" name="password" required 
                        placeholder="••••••••" 
                        class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#002B5B] hover:bg-blue-900 text-white font-bold py-3 rounded-xl text-sm transition shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2 mt-2">
                <span>Masuk Ke Sistem</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </button>
        </form>

        <div class="bg-slate-50 px-6 py-4 text-center border-t border-slate-100">
            <a href="{{ url('/') }}" class="text-xs text-slate-500 hover:text-[#002B5B] transition font-medium">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda Utama
            </a>
        </div>
    </div>

</body>
</html>