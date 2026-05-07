<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TextEnhancementController extends Controller
{
    public function enhance(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000',
        ]);

        // Ambil semua master tag dari database
        $tags = Tag::select('id', 'name')->get();
        $tagsList = $tags->map(fn($t) => "- ID: {$t->id} | Nama: {$t->name}")->implode("\n");

        // Prompt terstruktur yang memaksa output JSON dan mengerti konteks Skripsi IT
        $prompt = "Tugas Anda ada dua:
            1. Perbaiki tata bahasa teks revisi klien (biasanya mahasiswa skripsi IT) berikut. Bikin santai, luwes, tapi tetap sopan dan jelas maksudnya secara profesional. Jangan tambahkan basa-basi.
               ATURAN FORMAT MUTLAK: Susun ulang dan kelompokkan semua catatan revisi menjadi format POIN-POIN ANGKA (1., 2., 3., dst). DILARANG KERAS menggunakan bullet point seperti strip (-), asterisk (*), atau titik bulat. Pastikan setiap poin mudah dibaca oleh programmer.
            2. Analisis teks tersebut dan pilih ID tag yang PALING RELEVAN dari daftar tag Karyantara di bawah ini. Anda harus cerdas menangkap konteks tersirat!
               - KUNCI 1: Jika klien diminta 'ganti judul' atau 'saran judul', OTOMATIS pilih tag 'Ganti Judul Skripsi', 'Naskah Bab 1', dan 'Naskah Bab 2' (karena ganti judul pasti merubah latar belakang & tinjauan pustaka).
               - KUNCI 2: Jika ada permintaan 'notif', 'pesan wa', 'whatsapp', 'email', pilih tag 'Notif WhatsApp/Email'.
               - KUNCI 3: Jika ada kata 'ui', 'tampilan', pilih tag 'UI/UX & Tampilan'.
               - KUNCI 4: Jika ada kata 'activity', 'alur', pilih tag 'UML Activity Diagram' dan 'Alur Sistem (Flow)'.
               - KUNCI 5: Jika ada kata 'aktor', 'role', pilih tag 'Manajemen Role/Aktor' dan 'UML Use Case'.
               - KUNCI 6: Jika ada kata 'cetak', 'pdf', 'laporan', pilih tag 'Export PDF/Laporan'.
               (Pilih maksimal 7 tag, jika tidak ada kembalikan array kosong).
                
            [DAFTAR TAG KARYANTARA]
            {$tagsList}
                
            [TEKS KLIEN]
            {$request->text}
                
            PENTING: Kembalikan HANYA dalam format JSON murni dengan struktur persis seperti ini, pastikan 'suggested_tags' berisi ARRAY INTEGER dari ID tag, dan 'enhanced_text' berisi format angka:
            {
                \"enhanced_text\": \"1. Teks revisi satu.\\n2. Teks revisi dua.\\n3. Teks revisi tiga.\",
                \"suggested_tags\": [1, 5, 8, 12, 14] 
            }";

        try {
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant that strictly outputs valid JSON only.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    // Aktifkan mode JSON untuk stabilitas ekstra
                    'response_format' => ['type' => 'json_object'],
                    'temperature' => 0.3, // Turunkan sedikit agar AI lebih logis dan deterministik
                ]);

            if ($response->successful()) {
                // 1. Ambil raw text dari AI
                $rawContent = $response->json('choices.0.message.content');
                
                // 2. Bersihkan bungkus markdown (```json dan ```) jika AI membandel
                $cleanContent = preg_replace('/```json\s*|```/', '', $rawContent);
                
                // 3. Decode JSON dari AI
                $content = json_decode($cleanContent, true);

                return response()->json([
                    'success' => true,
                    'result' => $content['enhanced_text'] ?? $request->text,
                    'suggested_tags' => $content['suggested_tags'] ?? [] // Kirim array ID tag ke frontend
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Gagal menghubungi server AI.'], 500);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem.'], 500);
        }
    }
}