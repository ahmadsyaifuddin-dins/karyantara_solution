<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; // TAMBAHAN
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat; // TAMBAHAN

class MyEarningsExport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $month;
    protected $year;
    protected $userId;

    public function __construct($month, $year, $userId)
    {
        $this->month = $month;
        $this->year = $year;
        $this->userId = $userId;
    }

    public function view(): View
    {
        $appQuery = Project::where('programmer_id', $this->userId);
        $writerQuery = Project::where('writer_id', $this->userId);

        if ($this->month != 'all') {
            $appQuery->whereMonth('created_at', $this->month);
            $writerQuery->whereMonth('created_at', $this->month);
        }
        if ($this->year != 'all') {
            $appQuery->whereYear('created_at', $this->year);
            $writerQuery->whereYear('created_at', $this->year);
        }

        $appProjects = $appQuery->orderBy('created_at', 'desc')->get();
        $writerProjects = $writerQuery->orderBy('created_at', 'desc')->get();

        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        
        $periode = ($this->month == 'all' ? 'Semua Bulan' : $bulanIndo[(int)$this->month]) . ' ' . ($this->year == 'all' ? 'Semua Tahun' : $this->year);

        return view('admin.earnings.excel', compact('appProjects', 'writerProjects', 'periode'));
    }

    // FORMAT CURRENCY / UANG UNTUK KOLOM E (Nominal)
    public function columnFormats(): array
    {
        return [
            'E' => '#,##0', // Format ribuan standar Excel
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 14]],
            2    => ['font' => ['bold' => true]],
            3    => ['font' => ['bold' => true]],
        ];
    }
}