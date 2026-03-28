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
            'current_balance' => 'nullable|numeric|min:0',
            'model' => 'required|string',
        ]);

        // 1. Ambil data keuangan PRIBADI (dari Sistem Karyantara)
        $finances = $this->calculatePersonalEarnings(Auth::id());
        $totalPiutang = $finances['piutang']; // Kita cuma butuh Piutangnya saja
        
        // 2. Data dari Form
        $item = $request->target_item;
        $price = $request->target_price;
        $priceText = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Tolong estimasikan harganya';
        
        // Saldo Realita (SeaBank, BCA, dll)
        $currentBalance = $request->current_balance ?: 0;
        
        // --- LOGIKA MATEMATIKA REALITA ---
        // Jika form saldo diisi, jadikan itu sebagai SATU-SATUNYA acuan uang tunai.
        // Jika dikosongkan (0), baru kita pakai backup dari sistem Karyantara (cair).
        $totalLiquidCash = $currentBalance > 0 ? $currentBalance : $finances['paid']; 
        
        // Total Estimasi = Uang Real di Rekening + Uang Nyangkut di Klien
        $totalEstimatedAssets = $totalLiquidCash + $totalPiutang; 
        
        // 3. Racik System Prompt
        $systemPrompt = "Anda adalah 'Asisten Finansial & Tech Advisor' eksklusif untuk staf di Karyantara Solution. 
Tugas Anda adalah memberikan saran logis dan realistis mengenai rencana belanja barang pribadi.
Gunakan bahasa Indonesia yang profesional, modern, namun tetap santai (ala tech startup).
PENTING TENTANG FORMAT OUTPUT (WAJIB MARKDOWN):
1. WAJIB gunakan Markdown Table (Tabel) untuk menyajikan rincian cashflow dan perhitungan matematis.
2. Gunakan Bullet Points (-) untuk kelebihan/kekurangan barang.
3. JANGAN gunakan format persamaan matematika/LaTeX (seperti \frac, \text). Gunakan teks biasa saja.
4. Perhatikan baik-baik 'Total Uang Tunai di Rekening' sebelum menyimpulkan defisit.";

        // 4. Racik User Prompt - SESUAI REALITA DOMPET
        $userPrompt = "Berikut adalah status keuangan REAL saya saat ini:
1. Uang Tunai di Rekening (Realita): Rp " . number_format($totalLiquidCash, 0, ',', '.') . " (Ini sudah termasuk gabungan fee yang cair dan uang cicilan masuk).
2. Piutang Fee Project (Belum Cair/Belum Lunas): Rp " . number_format($totalPiutang, 0, ',', '.') . "
--- TOTAL ASET ESTIMASI (Rekening + Piutang): Rp " . number_format($totalEstimatedAssets, 0, ',', '.') . " ---

Saya berencana membeli: **{$item}**.
Estimasi Harga: **{$priceText}**.

Tolong berikan laporan dengan susunan berikut:
1. Tabel Analisis Cashflow Pribadi: Hitung apakah 'Uang Tunai di Rekening' cukup untuk membeli barang tersebut? Jika kurang, hitung defisitnya. Lalu hitung sisa kekayaan saya JIKA memakai skema menunggu 'Piutang' cair sepenuhnya.
2. Review Barang & Spesifikasi: Apakah barang ini *worth it* untuk menunjang pekerjaan saya di bidang IT?
3. Rekomendasi Tempat Pembelian & Tips.";

        // 5. Tembak ke API Groq
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

        // 6. Simpan ke Database sebagai Histori
        $history = AiCalculationHistory::create([
            'admin_id' => Auth::id(),
            'target_item' => $item,
            'target_price' => $price,
            'financial_snapshot' => [
                'saldo_real_rekening' => $totalLiquidCash,
                'piutang_sistem' => $totalPiutang,
                'total_estimasi_aset' => $totalEstimatedAssets,
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