<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TextEnhancementController extends Controller
{
    public function enhance(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000',
        ]);

        // Prompt santai tapi tetap jelas dan profesional
        $prompt = "Tolong perbaiki dan rapikan tata bahasa teks berikut. Bikin gaya bahasanya santai, enak dibaca, luwes, tapi tetap sopan dan jelas maksudnya dalam konteks profesional. Jangan kaku atau terlalu formal. Jangan tambahkan basa-basi, komentar, atau tanda kutip, langsung berikan hasil perbaikannya saja:\n\n" . $request->text;

        try {
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.4,
                ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'result' => $response->json('choices.0.message.content')
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Gagal menghubungi server AI.'], 500);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem.'], 500);
        }
    }
}