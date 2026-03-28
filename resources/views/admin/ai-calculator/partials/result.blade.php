<div class="lg:col-span-8 flex flex-col h-full">
    <div
        class="bg-white rounded-2xl shadow-sm border border-gray-100 flex-grow flex flex-col overflow-hidden min-h-[600px]">
        <div class="p-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-bold text-[#1E293B] flex items-center gap-2">
                <i class="fa-solid fa-wand-magic-sparkles text-amber-500"></i> Laporan Analisis AI
            </h3>
            <span
                class="text-xs font-semibold bg-amber-100 text-amber-700 px-3 py-1 rounded-full border border-amber-200">
                Powered by Groq
            </span>
        </div>

        <div class="p-6 flex-grow overflow-y-auto bg-slate-50 relative custom-scrollbar">
            <div x-show="!result && !isLoading"
                class="flex flex-col items-center justify-center h-full text-gray-400 opacity-70 mt-10">
                <div
                    class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                    <i class="fa-solid fa-robot text-4xl text-gray-300"></i>
                </div>
                <p class="font-medium text-gray-500">Kalkulator siap. Masukkan data di sebelah kiri.</p>
            </div>

            <div x-show="isLoading" class="flex flex-col items-center justify-center h-full text-[#1E293B] mt-10">
                <div class="relative w-20 h-20 mb-6">
                    <div class="absolute inset-0 border-4 border-slate-200 rounded-full"></div>
                    <div
                        class="absolute inset-0 border-4 border-amber-500 rounded-full border-t-transparent animate-spin">
                    </div>
                    <i
                        class="fa-solid fa-brain absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-2xl text-[#1E293B] animate-pulse"></i>
                </div>
                <p class="font-bold text-lg animate-pulse text-[#1E293B]">Menganalisis Cashflow & Pasar...</p>
                <p class="text-sm text-gray-500 mt-2">Menyusun rekomendasi terbaik untuk Anda.</p>
            </div>

            <div x-show="result" style="display: none;">
                <div class="ai-content-wrapper bg-white p-6 md:p-8 rounded-xl border border-gray-100 shadow-sm"
                    x-html="renderedResult"></div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar biar estetik */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #CBD5E1;
        border-radius: 20px;
    }

    /* --- STYLING KONTEN AI --- */
    .ai-content-wrapper {
        color: #334155;
        /* slate-700 */
        font-size: 0.95rem;
        line-height: 1.7;
    }

    /* Headings */
    .ai-content-wrapper h1,
    .ai-content-wrapper h2,
    .ai-content-wrapper h3 {
        color: #1E293B;
        font-weight: 800;
        margin-top: 1.5em;
        margin-bottom: 0.75em;
        line-height: 1.3;
    }

    .ai-content-wrapper h1 {
        font-size: 1.5rem;
        border-bottom: 2px solid #F1F5F9;
        padding-bottom: 0.5rem;
    }

    .ai-content-wrapper h2 {
        font-size: 1.25rem;
    }

    .ai-content-wrapper h3 {
        font-size: 1.1rem;
        color: #475569;
    }

    /* Paragraf & Teks Bold */
    .ai-content-wrapper p {
        margin-bottom: 1.2em;
    }

    .ai-content-wrapper strong {
        color: #0F172A;
        font-weight: 700;
        background-color: #FFFBEB;
        padding: 0 4px;
        border-radius: 4px;
    }

    /* Lists (Bullet & Number) */
    .ai-content-wrapper ul,
    .ai-content-wrapper ol {
        margin-bottom: 1.2em;
        padding-left: 1.5em;
    }

    .ai-content-wrapper ul {
        list-style-type: none;
    }

    .ai-content-wrapper ul li {
        position: relative;
        margin-bottom: 0.5em;
    }

    .ai-content-wrapper ul li::before {
        content: '■';
        color: #F59E0B;
        /* amber-500 */
        position: absolute;
        left: -1.2em;
        top: -0.1em;
        font-size: 0.8em;
    }

    .ai-content-wrapper ol li {
        margin-bottom: 0.5em;
        padding-left: 0.5em;
    }

    .ai-content-wrapper ol li::marker {
        color: #1E293B;
        font-weight: bold;
    }

    /* Blockquote (Saran Penting) */
    .ai-content-wrapper blockquote {
        border-left: 4px solid #F59E0B;
        /* amber-500 */
        background-color: #FFFBEB;
        /* amber-50 */
        padding: 1em 1.5em;
        margin: 1.5em 0;
        border-radius: 0 8px 8px 0;
        color: #92400E;
        /* amber-800 */
        font-style: normal;
        font-weight: 500;
    }

    /* JURUS UTAMA: TABEL YANG RAPI */
    .ai-content-wrapper table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5em 0;
        font-size: 0.9rem;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .ai-content-wrapper thead {
        background-color: #1E293B;
        /* Warna Karyantara */
        color: #ffffff;
        text-align: left;
    }

    .ai-content-wrapper th {
        padding: 12px 16px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .ai-content-wrapper td {
        padding: 12px 16px;
        border-bottom: 1px solid #E2E8F0;
        color: #475569;
    }

    .ai-content-wrapper tbody tr:last-of-type td {
        border-bottom: none;
    }

    .ai-content-wrapper tbody tr:nth-of-type(even) {
        background-color: #F8FAFC;
        /* Zebra striping */
    }

    .ai-content-wrapper tbody tr:hover {
        background-color: #F1F5F9;
        transition: background-color 0.2s ease;
    }

    /* Link */
    .ai-content-wrapper a {
        color: #D97706;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 1px dashed #D97706;
    }

    .ai-content-wrapper a:hover {
        color: #B45309;
        border-bottom-style: solid;
    }
</style>
