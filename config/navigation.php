<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Menu Navigasi Admin Karyantara
    |--------------------------------------------------------------------------
    | Di sini tempat mengatur menu sidebar. Tidak perlu edit file Blade lagi!
    | Tinggal tambahkan array baru di bawah ini.
    |
    */

    'groups' => [
        // GRUP 1: Tanpa Judul (Utama)
        [
            'heading' => null,
            'items' => [
                [
                    'title' => 'Dashboard',
                    'route' => 'admin.dashboard',
                    'active_match' => 'admin.dashboard',
                    'icon' => 'fa-solid fa-gauge-high',
                    'permission' => 'view_dashboard',
                ],
                [
                    'title' => 'Ruang Ikhtiar',
                    'route' => 'admin.ikhtiar',
                    'active_match' => 'admin.ikhtiar',
                    'icon' => 'fa-solid fa-leaf',
                    'permission' => 'view_ikhtiar',
                ],
            ],
        ],

        // GRUP 2: Operasional & Finansial
        [
            'heading' => 'Operasional & Finansial',
            'items' => [
                [
                    'title' => 'Daftar Klien & Proyek',
                    'route' => 'admin.projects.index',
                    'active_match' => 'admin.projects.*',
                    'icon' => 'fa-solid fa-file-invoice-dollar',
                    'permission' => 'manage_projects',
                ],
                [
                    'title' => 'Board Revisi',
                    'route' => 'admin.revisions.board',
                    'active_match' => 'admin.revisions.*',
                    'icon' => 'fa-solid fa-clipboard-list',
                    'permission' => 'manage_revisions',
                ],
                [
                    'title' => 'Pendapatan Saya',
                    'route' => 'admin.earnings.index',
                    'active_match' => 'admin.earnings.*',
                    'icon' => 'fa-solid fa-wallet',
                    'permission' => 'manage_earnings',
                ],
                [
                    'title' => 'Agenda & Rapat',
                    'route' => 'admin.meetings.index',
                    'active_match' => 'admin.meetings.*',
                    'icon' => 'fa-solid fa-calendar-check',
                    'permission' => 'manage_meetings',
                ],
                [
                    'title' => 'Kalkulator AI',
                    'route' => 'admin.ai-calculator.index',
                    'active_match' => 'admin.ai-calculator.*',
                    'icon' => 'fa-solid fa-robot',
                    'permission' => 'use_ai_calculator',
                    'is_special' => true, // <-- Menandakan ini tombol spesial berkedip
                ],
                [
                    'title' => 'Estimasi Harga',
                    'route' => 'admin.pricing-calculator',
                    'active_match' => 'admin.pricing-calculator',
                    'icon' => 'fa-solid fa-calculator',
                    'permission' => 'use_pricing_calculator',
                ],
            ],
        ],

        // GRUP 3: Manajemen Konten
        [
            'heading' => 'Manajemen Konten',
            'items' => [
                [
                    'title' => 'Portofolio',
                    'route' => 'admin.portfolios.index',
                    'active_match' => 'admin.portfolios.*',
                    'icon' => 'fa-solid fa-briefcase',
                    'permission' => 'manage_portfolios',
                ],
                [
                    'title' => 'Testimonial',
                    'route' => 'admin.testimonials.index',
                    'active_match' => 'admin.testimonials.*',
                    'icon' => 'fa-solid fa-comments',
                    'permission' => 'manage_testimonials',
                    'has_badge' => true, // <-- Memberitahu Blade untuk ngecek Notif/Badge
                ],
            ],
        ],

        // GRUP 4: Sistem & Konfigurasi
        [
            'heading' => 'Sistem & Konfigurasi',
            'items' => [
                [
                    'title' => 'Struktur Organisasi',
                    'route' => 'admin.struktur',
                    'active_match' => 'admin.struktur',
                    'icon' => 'fa-solid fa-sitemap',
                    'permission' => 'view_struktur',
                ],
                [
                    'title' => 'Kelola Jabatan',
                    'route' => 'admin.positions.index',
                    'active_match' => 'admin.positions.*',
                    'icon' => 'fa-solid fa-id-badge',
                    'permission' => 'manage_positions',
                ],
                [
                    'title' => 'Kelola Admin', // Sekalian ganti nama biar jelas
                    'route' => 'admin.admins.index',
                    'active_match' => 'admin.admins.*',
                    'icon' => 'fa-solid fa-users-gear',
                    'permission' => 'manage_admins',
                ],
                [
                    'title' => 'Statistik Pengunjung',
                    'route' => 'admin.visitors.index',
                    'active_match' => 'admin.visitors.*',
                    'icon' => 'fa-solid fa-chart-line',
                    'permission' => 'view_visitors',
                ],
                [
                    'title' => 'Pengaturan Sistem',
                    'route' => 'admin.settings.index',
                    'active_match' => 'admin.settings.*',
                    'icon' => 'fa-solid fa-cogs',
                    'permission' => 'manage_settings',
                ],
                [
                    'title' => 'RBAC',
                    'route' => 'admin.roles.index',
                    'active_match' => 'admin.roles.*',
                    'icon' => 'fa-solid fa-shield-halved',
                    'permission' => 'manage_roles',
                ],
            ],
        ],
    ],
];
