<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        // Ambil data dari database
        $projects = Project::where('is_shared', 1)->orWhere('admin_id', auth()->id())->latest()->get();

        // Hitung Total Pendapatan
        $totalNet = $projects->sum('net_income');
        $totalPaid = $projects->sum('paid_amount');
        $totalRemaining = $totalNet - $totalPaid;

        // Sisipkan baris Total ke urutan paling bawah data collection
        $projects->push((object) [
            'is_total_row' => true,
            'net_income' => $totalNet,
            'paid_amount' => $totalPaid,
            'remaining_amount' => $totalRemaining,
        ]);

        return $projects;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tipe Klien',
            'Nama Klien',
            'NPM',
            'Judul Skripsi / Deskripsi',
            'Status',
            'Harga Fix (Rp)',
            'Terbayar (Rp)',
            'Sisa (Rp)',
            'Metode Pembayaran',
        ];
    }

    public function map($project): array
    {
        // JIKA INI ADALAH BARIS TOTAL PENDAPATAN (Yang kita sisipkan di collection)
        if (isset($project->is_total_row)) {
            return [
                '', '', '', '', '', 'TOTAL KESELURUHAN',
                number_format($project->net_income, 0, '', ','), // Format pemisah koma
                number_format($project->paid_amount, 0, '', ','),
                number_format($project->remaining_amount, 0, '', ','),
                '',
            ];
        }

        // JIKA INI BARIS DATA BIASA
        static $urutan = 0;
        $urutan++;

        return [
            $urutan,
            strtoupper($project->client_type),
            $project->client_name,
            $project->npm ?? '-',
            $project->skripsi_title ?? $project->project_description,
            $project->status,
            number_format($project->net_income, 0, '', ','), // Format pemisah koma
            number_format($project->paid_amount, 0, '', ','),
            number_format($project->remaining_amount, 0, '', ','),
            strtoupper($project->payment_method),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $range = 'A1:'.$highestColumn.$highestRow;

        // Memberikan Style Border ke seluruh sel tabel
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Style untuk Header (Baris 1)
        $sheet->getStyle('A1:'.$highestColumn.'1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'E2E8F0'],
            ],
        ]);

        // Style untuk Baris Total (Baris Paling Bawah)
        $sheet->getStyle('A'.$highestRow.':'.$highestColumn.$highestRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FEF3C7'], // Warna kuning soft
            ],
        ]);
    }
}
