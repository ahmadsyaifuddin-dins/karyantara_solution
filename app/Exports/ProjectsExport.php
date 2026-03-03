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
    // Properti untuk melacak baris mana saja yang lunas
    private $currentRow = 1; // Dimulai dari 1 karena baris 1 dipakai oleh Heading
    private $lunasRows = [];

    public function collection()
    {
        $projects = Project::where(function ($query) {
                        $query->where('is_shared', 1)
                              ->orWhere('admin_id', auth()->id());
                    })
                    ->orderByRaw("CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END ASC")
                    ->orderBy('sort_order', 'asc')
                    ->latest()
                    ->get();

        $totalNet = $projects->sum('net_income');
        $totalPaid = $projects->sum('paid_amount');
        $totalRemaining = $totalNet - $totalPaid;

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
        // Setiap kali map() dipanggil, nomor baris Excel bertambah
        $this->currentRow++;

        if (isset($project->is_total_row)) {
            return [
                '', '', '', '', '', 'TOTAL KESELURUHAN',
                number_format($project->net_income, 0, '', ','),
                number_format($project->paid_amount, 0, '', ','),
                number_format($project->remaining_amount, 0, '', ','),
                '',
            ];
        }

        // Cek apakah proyek ini LUNAS, jika ya simpan nomor barisnya
        if ($project->is_paid_off) {
            $this->lunasRows[] = $this->currentRow;
        }

        static $urutan = 0;
        $urutan++;

        return [
            $urutan,
            strtoupper($project->client_type),
            $project->client_name,
            $project->npm ?? '-',
            $project->skripsi_title ?? $project->project_description,
            $project->status,
            number_format($project->net_income, 0, '', ','),
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

        // 1. Style Border untuk semua cell
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // 2. Style Header (Baris 1)
        $sheet->getStyle('A1:'.$highestColumn.'1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'E2E8F0'], // Abu-abu terang
            ],
        ]);

        // 3. Style Baris Total (Paling Bawah)
        $sheet->getStyle('A'.$highestRow.':'.$highestColumn.$highestRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FEF3C7'], // Kuning soft
            ],
        ]);

        // 4. SIHIR WARNA HIJAU UNTUK BARIS LUNAS
        // Kita looping array baris yang lunas tadi, lalu warnai sebarisan penuh
        foreach ($this->lunasRows as $rowIndex) {
            $sheet->getStyle('A'.$rowIndex.':'.$highestColumn.$rowIndex)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'D1FAE5'], // Hijau emerald-100 (Mirip dengan UI Website)
                ],
            ]);
        }
    }
}