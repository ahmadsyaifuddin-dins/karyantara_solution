<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // KATEGORI: APLIKASI & LOGIC
            ['name' => 'UI/UX & Tampilan', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700'],
            ['name' => 'Bug / Error Logic', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
            ['name' => 'Alur Sistem (Flow)', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
            ['name' => 'Manajemen Role/Aktor', 'bg' => 'bg-indigo-100', 'text' => 'text-indigo-700'],
            ['name' => 'Tambah Menu/Fitur', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
            ['name' => 'Export PDF/Laporan', 'bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
            ['name' => 'Database / Tabel', 'bg' => 'bg-slate-100', 'text' => 'text-slate-700'],
            ['name' => 'Perhitungan / Rumus', 'bg' => 'bg-[#1E293B]', 'text' => 'text-amber-500'],
            ['name' => 'Notif WhatsApp/Email', 'bg' => 'bg-teal-100', 'text' => 'text-teal-700'], // TAG BARU

            // KATEGORI: DESAIN UML & DIAGRAM
            ['name' => 'UML Use Case', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
            ['name' => 'UML Activity Diagram', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
            ['name' => 'UML Sequence Diagram', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
            ['name' => 'UML Class Diagram', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
            ['name' => 'ERD / Relasi Data', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],

            // KATEGORI: NASKAH SKRIPSI
            ['name' => 'Ganti Judul Skripsi', 'bg' => 'bg-rose-100', 'text' => 'text-rose-700'], // TAG BARU
            ['name' => 'Naskah Bab 1', 'bg' => 'bg-[#1E293B]', 'text' => 'text-white'],
            ['name' => 'Naskah Bab 2', 'bg' => 'bg-[#1E293B]', 'text' => 'text-white'],
            ['name' => 'Naskah Bab 3', 'bg' => 'bg-[#1E293B]', 'text' => 'text-white'],
            ['name' => 'Naskah Bab 4', 'bg' => 'bg-[#1E293B]', 'text' => 'text-white'],
            ['name' => 'Naskah Bab 5', 'bg' => 'bg-[#1E293B]', 'text' => 'text-white'],
            ['name' => 'Blackbox Testing', 'bg' => 'bg-slate-800', 'text' => 'text-amber-400'],
            ['name' => 'Format Penulisan', 'bg' => 'bg-gray-100', 'text' => 'text-gray-700'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['name' => $tag['name']], // Hindari duplikat jika seeder dijalankan ulang
                [
                    'slug' => Str::slug($tag['name']),
                    'bg_color' => $tag['bg'],
                    'text_color' => $tag['text'],
                ]
            );
        }
    }
}