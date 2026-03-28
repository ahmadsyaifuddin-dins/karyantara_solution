<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\AiCalculationHistory;
use App\Services\GroqApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiCalculatorController extends Controller
{
    protected $groqService;

    public function __construct(GroqApiService $groqService)
    {
        $this->groqService = $groqService;
    }

    /**
     * Helper untuk menghitung keuangan pribadi admin yang login
     */
    private function calculatePersonalEarnings($userId)
    {
        // Tarik project di mana user berperan sebagai programmer atau writer
        $appProjects = Project::where('programmer_id', $userId)->get();
        $writerProjects = Project::where('writer_id', $userId)->get();

        // 1. Total Omzet Pribadi (Semua Fee)
        $totalAppFee = $appProjects->sum('app_price');
        $totalWriterFee = $writerProjects->sum('writer_price');
        $myTotalIncome = $totalAppFee + $totalWriterFee;

        // 2. Total Cair (Fee yang status paid-nya sudah true)
        $paidAppFee = $appProjects->where('is_programmer_paid', true)->sum('app_price');
        $paidWriterFee = $writerProjects->where('is_writer_paid', true)->sum('writer_price');
        $myTotalPaid = $paidAppFee + $paidWriterFee;

        // 3. Piutang (Fee yang belum dibayar)
        $myTotalPiutang = $myTotalIncome - $myTotalPaid;
        if ($myTotalPiutang < 0) $myTotalPiutang = 0;

        return [
            'income' => $myTotalIncome,
            'paid' => $myTotalPaid,
            'piutang' => $myTotalPiutang
        ];
    }

    public function index()
    {
        $models = $this->groqService->getAvailableModels();

        // Ambil data keuangan PRIBADI
        $finances = $this->calculatePersonalEarnings(Auth::id());
        
        $totalNetIncome = $finances['income'];
        $totalPaid = $finances['paid'];
        $totalPiutang = $finances['piutang'];

        $histories = AiCalculationHistory::with('admin')
            ->where('admin_id', Auth::id()) // Tampilkan histori milik dia sendiri
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Set default model ke llama-3.1 atau model pertama yang tersedia
        $defaultModel = in_array('openai/gpt-oss-120b', $models) ? 'openai/gpt-oss-120b' : ($models[0] ?? 'openai/gpt-oss-120b');

        return view('admin.ai-calculator.index', compact(
            'models', 'totalNetIncome', 'totalPaid', 'totalPiutang', 'histories', 'defaultModel'
        ));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'target_item' => 'required|string|max:255',
            'target_price' => 'nullable|numeric|min:0',
            'model' => 'required|string',
        ]);

        // Ambil data keuangan PRIBADI
        $finances = $this->calculatePersonalEarnings(Auth::id());
        $totalNetIncome = $finances['income'];
        $totalPaid = $finances['paid'];
        $totalPiutang = $finances['piutang'];
        
        $item = $request->target_item;
        $price = $request->target_price;
        $priceText = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Tolong estimasikan harganya';

        // 2. Racik System Prompt (Karakteristik AI)
        $systemPrompt = "Anda adalah 'Asisten Finansial & Tech Advisor' eksklusif untuk staf di Karyantara Solution. 
Tugas Anda adalah memberikan saran logis dan realistis mengenai rencana belanja barang pribadi menggunakan uang komisi/fee dari project.
Gunakan bahasa Indonesia yang profesional, modern, namun tetap santai (ala tech startup).
PENTING TENTANG FORMAT OUTPUT (WAJIB MARKDOWN):
1. WAJIB gunakan Markdown Table (Tabel) untuk menyajikan rincian angka, perbandingan harga, atau cashflow agar rapi.
2. Gunakan Bullet Points (-) untuk kelebihan/kekurangan barang.
3. Gunakan Bold (**) untuk penekanan angka atau kesimpulan penting.
4. JANGAN gunakan format persamaan matematika/LaTeX (seperti \frac, \text). Gunakan teks biasa untuk hitungan.
Jangan berikan pengantar basa-basi, langsung ke analisis.";

        // 3. Racik User Prompt (Konteks & Pertanyaan) - Fokus ke Dompet Pribadi
        $userPrompt = "Berikut adalah status keuangan PRIBADI saya (dari komisi project) saat ini:
- Total Fee Keseluruhan: Rp " . number_format($totalNetIncome, 0, ',', '.') . "
- Fee Sudah Cair (Uang di Tangan): Rp " . number_format($totalPaid, 0, ',', '.') . "
- Piutang Fee (Belum Cair): Rp " . number_format($totalPiutang, 0, ',', '.') . "

Saya berencana membeli: **{$item}**.
Estimasi Harga: **{$priceText}**.

Tolong berikan:
1. Analisis *Cashflow* Pribadi: Apakah aman membelinya sekarang menggunakan 'Uang di Tangan', atau harus menunggu 'Piutang' cair? (Berikan perhitungan rasionya).
2. Review Barang: Apakah barang ini *worth it* untuk menunjang pekerjaan saya di bidang IT/Software Development?
3. Rekomendasi Pembelian: Saran beli di mana (contoh: Tokopedia, Shopee, atau toko offline) beserta tipsnya.";

        // 4. Tembak ke API Groq
        $aiResponse = $this->groqService->generateFinancialAdvice(
            $request->model,
            $systemPrompt,
            $userPrompt
        );

        if (str_contains($aiResponse, 'Maaf, AI sedang sibuk')) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan respon dari AI. Coba gunakan model lain.'
            ], 500);
        }

        // 5. Simpan ke Database sebagai Histori
        $history = AiCalculationHistory::create([
            'admin_id' => Auth::id(),
            'target_item' => $item,
            'target_price' => $price,
            'financial_snapshot' => [
                'omzet_pribadi' => $totalNetIncome,
                'cair_pribadi' => $totalPaid,
                'piutang_pribadi' => $totalPiutang,
            ],
            'ai_advice' => $aiResponse,
            'model_used' => $request->model,
        ]);

        return response()->json([
            'success' => true,
            'data' => $aiResponse,
            'history_id' => $history->id
        ]);
    }

    public function showHistory($id)
    {
        $history = AiCalculationHistory::where('admin_id', Auth::id())
                    ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $history->ai_advice,
            'item' => $history->target_item
        ]);
    }
}