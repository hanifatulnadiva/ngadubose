<nav class="bg-[#F0F7FF] border-b border-blue-100 py-4 sticky top-0 z-50 shadow-sm px-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-2xl font-black tracking-wider text-[#002B5B]">
            ngadubose
        </a>

        <div class="hidden md:flex items-center space-x-1">
            
            <a href="{{ url('/') }}" 
               class="px-4 py-2 rounded-full text-sm font-semibold transition 
               {{ Request::is('/') ? 'bg-[#002B5B] text-white shadow-md' : 'text-slate-600 hover:text-[#002B5B] hover:bg-blue-100/50' }}">
               Beranda
            </a>
            
            <a href="{{ url('/lacak-status') }}" 
               class="px-4 py-2 rounded-full text-sm font-semibold transition 
               {{ Request::is('lacak-status*') ? 'bg-[#002B5B] text-white shadow-md' : 'text-slate-600 hover:text-[#002B5B] hover:bg-blue-100/50' }}">
               Lacak Laporan
            </a>
            
            <!-- <a href="{{ url('/#tentang') }}" 
               class="px-4 py-2 rounded-full text-sm font-medium transition text-slate-600 hover:text-[#002B5B] hover:bg-blue-100/50">
               Tentang
            </a> -->
        </div>

        <div>
            <a href="{{ url('/form-lapor') }}" class="inline-flex items-center gap-2 bg-[#002B5B] hover:bg-blue-900 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-md shadow-blue-900/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Buat Laporan
            </a>
        </div>
    </div>
</nav>