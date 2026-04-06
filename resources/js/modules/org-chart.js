import Swal from 'sweetalert2';

document.addEventListener('alpine:init', () => {
    Alpine.data('orgChart', (initialData = []) => ({
        searchQuery: '',
        struktur: [], 

        init() {
            // Mapping data dari database ke state Alpine
            this.struktur = initialData.map(pucuk => ({
                ...pucuk,
                isOpen: true,
                // Pastikan children bawaan ada, lalu petakan lagi grandchild-nya
                children: (pucuk.children || []).map(child => ({ 
                    ...child, 
                    isOpen: false,
                    children: child.children || [] 
                }))
            }));
        },

        get filteredStruktur() {
            if (this.searchQuery.trim() === '') {
                return this.struktur;
            }

            const query = this.searchQuery.toLowerCase();
            
            return this.struktur.map(pucuk => {
                // 1. Cek kecocokan di Level 1 (C-Suite)
                const matchPucuk = (pucuk.name || '').toLowerCase().includes(query) || 
                                   (pucuk.department || '').toLowerCase().includes(query);
                
                // 2. Filter Level 2 beserta pengecekan Level 3 di dalamnya
                const filteredBawahan = (pucuk.children || []).map(child => {
                    const matchChild = (child.name || '').toLowerCase().includes(query) || 
                                       (child.department || '').toLowerCase().includes(query);
                    
                    // Filter Level 3
                    const filteredGrandBawahan = (child.children || []).filter(gc => 
                        (gc.name || '').toLowerCase().includes(query) || 
                        (gc.department || '').toLowerCase().includes(query)
                    );

                    // Jika child cocok ATAU ada grandchild yang cocok, kembalikan child ini
                    if (matchChild || filteredGrandBawahan.length > 0) {
                        return { 
                            ...child, 
                            // Jika child yang dicari cocok, tampilkan semua grandchild. 
                            // Tapi jika cuma grandchild yang cocok, tampilkan grandchild yang difilter saja.
                            children: matchChild && filteredGrandBawahan.length === 0 ? child.children : filteredGrandBawahan 
                        };
                    }
                    return null;
                }).filter(item => item !== null);

                // Auto-open parent jika ada bawahan yang cocok dengan pencarian
                if (filteredBawahan.length > 0 && query !== '') {
                    pucuk.isOpen = true;
                }

                // 3. Gabungkan hasil. Tampilkan Level 1 jika cocok ATAU jika ada bawahannya yang cocok
                if (matchPucuk || filteredBawahan.length > 0) {
                    return { 
                        ...pucuk, 
                        children: matchPucuk && filteredBawahan.length === 0 ? pucuk.children : filteredBawahan 
                    };
                }
                return null;
            }).filter(item => item !== null);
        },

        toggleNode(node) {
            node.isOpen = !node.isOpen;
        },

        showDetail(item, isTopLevel = false) {
            // Ambil data personil dari relasi users
            const userList = item.users && item.users.length > 0 
                ? item.users.map(u => `<li class="text-sm text-gray-700 mt-1"><i class="fa-solid fa-user-check text-emerald-500 mr-2"></i><span class="font-bold">${u.name}</span></li>`).join('')
                : '<li class="text-sm text-gray-400 italic">Belum ada personil di posisi ini</li>';

            const iconBg = item.color_bg || 'bg-slate-100';
            const iconText = item.color_text || 'text-slate-700';
            const iconColorClass = isTopLevel ? `${iconBg} text-white` : `${iconBg} ${iconText} bg-opacity-20`;

            Swal.fire({
                html: `
                    <div class="text-left">
                        <div class="flex items-center gap-4 mb-4 border-b border-gray-100 pb-4">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center text-2xl shrink-0 ${iconColorClass}">
                                <i class="${item.icon || 'fa-solid fa-user-tie'}"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-[#1E293B]">${item.name}</h3>
                                <span class="text-sm font-semibold text-amber-500">${item.department || 'Tidak ada divisi'}</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">${item.description || 'Tidak ada deskripsi tugas.'}</p>
                        
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <h4 class="text-xs font-bold text-gray-400 uppercase mb-2 tracking-widest">Personil Terdaftar:</h4>
                            <ul class="space-y-1">${userList}</ul>
                        </div>
                    </div>
                `,
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-gray-100 bg-white p-6 max-w-md w-full',
                    actions: 'w-full mt-6 flex',
                    confirmButton: 'bg-[#1E293B] hover:bg-slate-800 text-white font-semibold py-3 px-8 w-full rounded-xl transition-all focus:outline-none block tracking-wide',
                },
                buttonsStyling: false,
                confirmButtonText: 'Tutup Detail'
            });
        }
    }));
});