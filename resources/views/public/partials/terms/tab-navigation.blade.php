<div class="flex justify-center mb-12">
    <div class="inline-flex flex-col sm:flex-row bg-gray-200/50 rounded-2xl p-1.5 shadow-inner gap-1 sm:gap-0">
        <button @click="activeTab = 'bisnis'"
            :class="activeTab === 'bisnis' ? 'bg-white shadow-md text-[#1E293B] font-extrabold scale-100' :
                'text-gray-500 hover:text-[#1E293B] font-semibold hover:bg-white/50 scale-95'"
            class="px-8 py-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-3 w-full sm:w-auto">
            <i class="fa-solid fa-building text-lg" :class="activeTab === 'bisnis' ? 'text-amber-500' : ''"></i>
            Klien Bisnis / Umum
        </button>

        <button @click="activeTab = 'mahasiswa'"
            :class="activeTab === 'mahasiswa' ? 'bg-white shadow-md text-[#1E293B] font-extrabold scale-100' :
                'text-gray-500 hover:text-[#1E293B] font-semibold hover:bg-white/50 scale-95'"
            class="px-8 py-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-3 w-full sm:w-auto">
            <i class="fa-solid fa-graduation-cap text-lg"
                :class="activeTab === 'mahasiswa' ? 'text-amber-500' : ''"></i>
            Klien Mahasiswa / Skripsi
        </button>
    </div>
</div>
