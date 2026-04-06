<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\User;

class PositionAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan updateOrCreate agar seeder aman dijalankan berulang kali (tidak duplikat)
        
        // ==========================================
        // LEVEL 1: PUCUK PIMPINAN (C-SUITE)
        // ==========================================
        $ceo = Position::updateOrCreate(
            ['name' => 'CEO (Chief Executive Officer)'],
            [
                'department' => 'Kerajaan Bisnis',
                'description' => 'Pucuk pimpinan tertinggi. Fokus pada uang, manusia, operasi, dan pertumbuhan perusahaan.',
                'icon' => 'fa-solid fa-briefcase',
                'color_bg' => 'bg-[#1E293B]',
                'color_text' => 'text-white',
                'parent_id' => null
            ]
        );

        $cto = Position::updateOrCreate(
            ['name' => 'CTO (Chief Technology Officer)'],
            [
                'department' => 'Kerajaan Teknologi',
                'description' => 'Pimpinan teknologi perusahaan. Fokus pada penciptaan produk, stabilitas sistem, dan inovasi.',
                'icon' => 'fa-solid fa-microchip',
                'color_bg' => 'bg-amber-500',
                'color_text' => 'text-[#1E293B]',
                'parent_id' => null
            ]
        );

        // ==========================================
        // UPDATE AKUN FOUNDER
        // ==========================================
        User::where('email', 'abdanmwmustaqim@gmail.com')->update([
            'role' => 'super_admin',
            'position_id' => $ceo->id,
        ]);

        User::where('email', 'ahmadsyai598@gmail.com')->update([
            'role' => 'super_admin',
            'position_id' => $cto->id,
        ]);


        // ==========================================
        // LEVEL 2: KERAJAAN BISNIS (BAWAHAN CEO)
        // ==========================================
        $cfo = Position::updateOrCreate(
            ['name' => 'CFO (Chief Financial Officer)'],
            [
                'department' => 'Keuangan & Pajak',
                'description' => 'Bertanggung jawab atas manajemen keuangan perusahaan, perencanaan keuangan, dan pencatatan arus kas.',
                'icon' => 'fa-solid fa-file-invoice-dollar',
                'color_bg' => 'bg-emerald-50',
                'color_text' => 'text-emerald-700',
                'parent_id' => $ceo->id
            ]
        );

        $coo = Position::updateOrCreate(
            ['name' => 'COO / CHRO'],
            [
                'department' => 'Operasional & HR',
                'description' => 'Mengurus operasional harian perusahaan, sumber daya manusia, legalitas, dan fasilitas kantor.',
                'icon' => 'fa-solid fa-users-gear',
                'color_bg' => 'bg-blue-50',
                'color_text' => 'text-blue-700',
                'parent_id' => $ceo->id
            ]
        );

        $cmo = Position::updateOrCreate(
            ['name' => 'CMO / CBO'],
            [
                'department' => 'Marketing & Bisnis',
                'description' => 'Ujung tombak pendapatan perusahaan. Fokus pada strategi pemasaran, penjualan, dan citra publik.',
                'icon' => 'fa-solid fa-bullhorn',
                'color_bg' => 'bg-purple-50',
                'color_text' => 'text-purple-700',
                'parent_id' => $ceo->id
            ]
        );

        // ==========================================
        // LEVEL 2: KERAJAAN TEKNOLOGI (BAWAHAN CTO)
        // ==========================================
        $engineering = Position::updateOrCreate(
            ['name' => 'Engineering Lead'],
            [
                'department' => 'Pengembangan Sistem',
                'description' => 'Tim yang bertugas memimpin penulisan kode dan membangun arsitektur sistem aplikasi secara teknis.',
                'icon' => 'fa-solid fa-code',
                'color_bg' => 'bg-[#1E293B]',
                'color_text' => 'text-white',
                'parent_id' => $cto->id
            ]
        );

        $productDesign = Position::updateOrCreate(
            ['name' => 'Head of Product & Design'],
            [
                'department' => 'Produk & Desain',
                'description' => 'Menjembatani kebutuhan bisnis dan user ke dalam bentuk desain (UI/UX) dan alur produk.',
                'icon' => 'fa-solid fa-pen-nib',
                'color_bg' => 'bg-rose-50',
                'color_text' => 'text-rose-700',
                'parent_id' => $cto->id
            ]
        );

        $qa = Position::updateOrCreate(
            ['name' => 'QA Lead (Quality Assurance)'],
            [
                'department' => 'Pengujian Kualitas',
                'description' => 'Memastikan tidak ada bug dan aplikasi berjalan sesuai spesifikasi sebelum rilis ke publik.',
                'icon' => 'fa-solid fa-bug-slash',
                'color_bg' => 'bg-emerald-50',
                'color_text' => 'text-emerald-700',
                'parent_id' => $cto->id
            ]
        );

        $infra = Position::updateOrCreate(
            ['name' => 'Infrastructure & Data Lead'],
            [
                'department' => 'Server & Database',
                'description' => 'Menjaga server tetap hidup (uptime), konfigurasi cloud, dan mengolah data perusahaan.',
                'icon' => 'fa-solid fa-server',
                'color_bg' => 'bg-gray-100',
                'color_text' => 'text-gray-700',
                'parent_id' => $cto->id
            ]
        );


        // ==========================================
        // LEVEL 3: SPESIALIS & STAFF
        // ==========================================
        
        // --- Bawahan Engineering ---
        Position::updateOrCreate(
            ['name' => 'Frontend Developer'],
            ['department' => 'Pengembangan Sistem', 'icon' => 'fa-brands fa-html5', 'color_bg' => 'bg-amber-500', 'color_text' => 'text-[#1E293B]', 'parent_id' => $engineering->id]
        );
        Position::updateOrCreate(
            ['name' => 'Backend Developer'],
            ['department' => 'Pengembangan Sistem', 'icon' => 'fa-brands fa-php', 'color_bg' => 'bg-blue-50', 'color_text' => 'text-blue-700', 'parent_id' => $engineering->id]
        );
        Position::updateOrCreate(
            ['name' => 'Mobile Developer'],
            ['department' => 'Pengembangan Sistem', 'icon' => 'fa-solid fa-mobile-screen', 'color_bg' => 'bg-emerald-50', 'color_text' => 'text-emerald-700', 'parent_id' => $engineering->id]
        );

        // --- Bawahan Product & Design ---
        Position::updateOrCreate(
            ['name' => 'UI/UX Designer'],
            ['department' => 'Produk & Desain', 'icon' => 'fa-solid fa-object-group', 'color_bg' => 'bg-purple-50', 'color_text' => 'text-purple-700', 'parent_id' => $productDesign->id]
        );

        // --- Bawahan Marketing & Creative (CMO) ---
        Position::updateOrCreate(
            ['name' => 'Digital Marketing Spec.'],
            ['department' => 'Marketing & Bisnis', 'icon' => 'fa-solid fa-chart-line', 'color_bg' => 'bg-rose-50', 'color_text' => 'text-rose-700', 'parent_id' => $cmo->id]
        );
        Position::updateOrCreate(
            ['name' => 'Content Creator'],
            ['department' => 'Creative Content', 'icon' => 'fa-solid fa-camera-retro', 'color_bg' => 'bg-amber-50', 'color_text' => 'text-amber-600', 'parent_id' => $cmo->id]
        );
        Position::updateOrCreate(
            ['name' => 'Video Editor'],
            ['department' => 'Creative Content', 'icon' => 'fa-solid fa-film', 'color_bg' => 'bg-[#1E293B]', 'color_text' => 'text-amber-500', 'parent_id' => $cmo->id]
        );
        Position::updateOrCreate(
            ['name' => 'Graphic Designer'],
            ['department' => 'Creative Content', 'icon' => 'fa-solid fa-palette', 'color_bg' => 'bg-fuchsia-50', 'color_text' => 'text-fuchsia-700', 'parent_id' => $cmo->id]
        );
        Position::updateOrCreate(
            ['name' => 'Copywriter'],
            ['department' => 'Creative Content', 'icon' => 'fa-solid fa-keyboard', 'color_bg' => 'bg-sky-50', 'color_text' => 'text-sky-700', 'parent_id' => $cmo->id]
        );
        Position::updateOrCreate(
            ['name' => 'Social Media Admin'],
            ['department' => 'Marketing & Bisnis', 'icon' => 'fa-solid fa-hashtag', 'color_bg' => 'bg-pink-50', 'color_text' => 'text-pink-600', 'parent_id' => $cmo->id]
        );
        
        // --- Bawahan HR (COO) ---
        Position::updateOrCreate(
            ['name' => 'HR Staff'],
            ['department' => 'Operasional & HR', 'icon' => 'fa-solid fa-address-card', 'color_bg' => 'bg-gray-100', 'color_text' => 'text-gray-700', 'parent_id' => $coo->id]
        );
    }
}