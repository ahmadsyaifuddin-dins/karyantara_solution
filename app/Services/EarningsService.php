<?php

namespace App\Services;

use App\Models\Project;

class EarningsService
{
    /**
     * Mengambil statistik lengkap pendapatan seorang user
     */
    public function getPersonalStats($userId, $month = 'all', $year = 'all')
    {
        // 1. Base Queries
        $appQuery = Project::where('programmer_id', $userId);
        $writerQuery = Project::where('writer_id', $userId);
        $umumQuery = Project::where('client_type', 'umum')
            ->where(function($q) use ($userId) {
                $q->whereJsonContains('custom_team', ['user_id' => (string)$userId])
                  ->orWhereJsonContains('custom_team', ['user_id' => $userId]);
            });

        // 2. Terapkan Filter (Jika Ada)
        if ($month != 'all') {
            $appQuery->whereMonth('created_at', $month);
            $writerQuery->whereMonth('created_at', $month);
            $umumQuery->whereMonth('created_at', $month);
        }
        if ($year != 'all') {
            $appQuery->whereYear('created_at', $year);
            $writerQuery->whereYear('created_at', $year);
            $umumQuery->whereYear('created_at', $year);
        }

        // 3. Eksekusi Query
        $appProjects = $appQuery->orderBy('created_at', 'desc')->get();
        $writerProjects = $writerQuery->orderBy('created_at', 'desc')->get();
        $umumProjects = $umumQuery->orderBy('created_at', 'desc')->get();

        // --- KALKULASI PROGRAMMER (MAHASISWA) ---
        $appProjectsMahasiswa = $appProjects->where('client_type', 'mahasiswa');
        $pendapatanDevMahasiswa = $appProjectsMahasiswa->sum('app_price');
        $totalAppEarnings = $appProjects->sum('app_price');
        $unpaidAppEarnings = $appProjects->where('is_programmer_paid', false)->sum('app_price'); 
        $completedAppProjects = $appProjects->where('status', 'Selesai');
        $completedAppEarnings = $completedAppProjects->sum('app_price');

        // --- KALKULASI WRITER ---
        $totalWriterEarnings = $writerProjects->sum('writer_price');
        $unpaidWriterEarnings = $writerProjects->where('is_writer_paid', false)->sum('writer_price');
        $completedWriterProjects = $writerProjects->where('status', 'Selesai');
        $completedWriterEarnings = $completedWriterProjects->sum('writer_price');

        // --- KALKULASI UMUM (CORPORATE VIA JSON) ---
        $pendapatanDevUmum = 0;
        $completedUmumEarnings = 0;
        $unpaidUmumEarnings = 0;

        foreach ($umumProjects as $proj) {
            $team = is_string($proj->custom_team) ? json_decode($proj->custom_team, true) : $proj->custom_team;
            if (is_array($team)) {
                foreach ($team as $member) {
                    if (isset($member['user_id']) && $member['user_id'] == $userId) {
                        $fee = (float) ($member['fee'] ?? 0);
                        $pendapatanDevUmum += $fee;
                        
                        $isPaid = $member['is_paid'] ?? false;
                        if (!$isPaid) {
                            $unpaidUmumEarnings += $fee;
                        }
                        
                        if ($proj->status == 'Selesai') {
                            $completedUmumEarnings += $fee;
                        }
                    }
                }
            }
        }

        // --- TOTAL KESELURUHAN ---
        $totalEarnings = $totalAppEarnings + $totalWriterEarnings + $pendapatanDevUmum;
        $totalUnpaidEarnings = $unpaidAppEarnings + $unpaidWriterEarnings + $unpaidUmumEarnings; 
        $totalPaidEarnings = $totalEarnings - $totalUnpaidEarnings;
        $totalProjects = $appProjects->count() + $writerProjects->count() + $umumProjects->count();

        $totalCompletedEarnings = $completedAppEarnings + $completedWriterEarnings + $completedUmumEarnings;
        $totalCompletedProjects = $completedAppProjects->count() + $completedWriterProjects->count() + $umumProjects->where('status', 'Selesai')->count();

        return [
            // Return raw collections for detailed views
            'appProjects' => $appProjects,
            'writerProjects' => $writerProjects,
            'umumProjects' => $umumProjects,
            
            // Return calculated metrics (Untuk Dashboard)
            'myAppProjectsCount' => $appProjectsMahasiswa->count(),
            'myAppEarnings' => $pendapatanDevMahasiswa,
            'myWriterProjectsCount' => $writerProjects->count(),
            'myWriterEarnings' => $totalWriterEarnings, 
            'myUmumProjectsCount' => $umumProjects->count(),
            'myUmumEarnings' => $pendapatanDevUmum,
            'myTotalEarnings' => $totalEarnings,
            'myTotalProjects' => $totalProjects,
            
            // Return variables (Untuk Dompet Pendapatan / Wallet Cards)
            'pendapatanDevMahasiswa' => $pendapatanDevMahasiswa,
            'totalAppEarnings' => $totalAppEarnings,
            'unpaidAppEarnings' => $unpaidAppEarnings,
            'completedAppEarnings' => $completedAppEarnings,
            
            'totalWriterEarnings' => $totalWriterEarnings,
            'unpaidWriterEarnings' => $unpaidWriterEarnings,
            'completedWriterEarnings' => $completedWriterEarnings,
            
            'pendapatanDevUmum' => $pendapatanDevUmum,
            'unpaidUmumEarnings' => $unpaidUmumEarnings,
            'completedUmumEarnings' => $completedUmumEarnings,
            
            'totalEarnings' => $totalEarnings,
            'totalUnpaidEarnings' => $totalUnpaidEarnings,
            'totalPaidEarnings' => $totalPaidEarnings,
            'totalProjects' => $totalProjects,
            'totalCompletedEarnings' => $totalCompletedEarnings,
            'totalCompletedProjects' => $totalCompletedProjects,
        ];
    }
}