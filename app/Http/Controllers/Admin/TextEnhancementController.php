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


            $prompt = "Tugas Anda ada dua:
            1. Perbaiki tata bahasa teks revisi klien berikut. Bikin santai, luwes, tapi tetap sopan dan jelas maksudnya secara profesional. Jangan tambahkan basa-basi.
               ATURAN FORMAT MUTLAK: 
               - Jika teks menyebutkan sumber/nama penguji (misal 'dari penguji 1', 'panelis 2'), ubah menjadi format SUB-JUDUL TEBAL (misal: Dari Penguji 1 (Naskah)).
               - Di bawah setiap sub-judul penguji, susun revisinya menjadi POIN-POIN ANGKA (1., 2., 3., dst). Mulai dari angka 1 lagi untuk setiap penguji.
               - DILARANG KERAS menggunakan bullet point seperti strip (-) atau titik bulat. Harus berupa angka.

            2. Analisis teks tersebut dan pilih ID tag yang PALING RELEVAN dari daftar tag Karyantara di bawah ini. Cerdaslah menangkap konteks tersirat!
               - KUNCI 1: Jika klien diminta 'ganti judul', pilih tag 'Ganti Judul Skripsi', 'Naskah Bab 1', dan 'Naskah Bab 2'.
               - KUNCI 2: Jika ada permintaan 'notif', 'pesan wa', 'whatsapp', 'email', pilih tag 'Notif WhatsApp/Email'.
               - KUNCI 3: Jika ada 'koordinat', 'lokasi', 'maps', 'geo-tagging', pilih tag 'Maps / Titik Koordinat'.
               - KUNCI 4: Jika ada 'scan', 'qr code', 'barcode', pilih tag 'QR Code / Barcode'.
               - KUNCI 5: Jika ada penyebutan aktor baru/berubah (misal: 'admin inventaris, petugas lapangan, kepala BPK'), ini berarti perombakan role! Pilih tag 'Ganti/Hapus Role', 'Manajemen Role/Aktor', dan 'UML Use Case'.
               - KUNCI 6: Jika ada kata 'cetak', 'pdf', 'excel', 'laporan', pilih tag 'Export PDF/Laporan'.
               (Pilih maksimal 7 tag, jika tidak ada kembalikan array kosong).

            [DAFTAR TAG KARYANTARA]
            {$tagsList}

            [TEKS KLIEN]
            {$request->text}

            PENTING: Kembalikan HANYA dalam format JSON murni. Pastikan 'suggested_tags' berisi ARRAY INTEGER, dan 'enhanced_text' mengikuti contoh format ini (gunakan \\n untuk enter):
            {
                \"enhanced_text\": \"**Dari Penguji 1 (Naskah)**\\n1. Autentikasi multi-role untuk admin inventaris, petugas lapangan, dan kepala BPK.\\n2. Fitur notifikasi peringatan...\\n\\n**Dari Penguji 2 (Aplikasi)**\\n1. Sebaiknya ditambahkan jadwal...\",
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