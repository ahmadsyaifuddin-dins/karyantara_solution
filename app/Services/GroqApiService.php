<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqApiService
{
    protected $baseUrl = 'https://api.groq.com/openai/v1';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
    }

    /**
     * Mengambil daftar model gratis yang tersedia di Groq
     */
    public function getAvailableModels()
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->get("{$this->baseUrl}/models");

            if ($response->successful()) {
                // Filter model agar hanya mengambil yang umum digunakan (opsional)
                $models = collect($response->json('data'))->where('active', true)->pluck('id');
                return $models->toArray();
            }

            return ['llama3-8b-8192', 'mixtral-8x7b-32768']; // Fallback jika gagal fetch
        } catch (\Exception $e) {
            Log::error('Groq API Error (Models): ' . $e->getMessage());
            return ['llama3-8b-8192']; // Default fallback
        }
    }

    /**
     * Meminta saran keuangan dari AI
     */
    public function generateFinancialAdvice(string $model, string $systemPrompt, string $userPrompt)
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(60) // AI butuh waktu berpikir
                ->post("{$this->baseUrl}/chat/completions", [
                    'model' => $model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemPrompt
                        ],
                        [
                            'role' => 'user',
                            'content' => $userPrompt
                        ]
                    ],
                    'temperature' => 0.7, // 0.7 cukup untuk objektivitas namun tetap kreatif
                    'max_tokens' => 2000,
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('Groq API Failed: ' . $response->body());
            return "Maaf, AI sedang sibuk atau terjadi kesalahan sistem. Silakan coba lagi.";
        } catch (\Exception $e) {
            Log::error('Groq Exception: ' . $e->getMessage());
            return "Terjadi kesalahan koneksi ke server AI.";
        }
    }
}