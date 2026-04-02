<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Services\EarningsService; 

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
        // 1. Panggil Service untuk mengambil data Mahasiswa, Naskah, dan Corporate
        $earningsService = app(EarningsService::class);
        $stats = $earningsService->getPersonalStats($this->userId, $this->month, $this->year);

        // 2. Format Periode Bulan
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        
        $periode = ($this->month == 'all' ? 'Semua Bulan' : $bulanIndo[(int)$this->month]) . ' ' . ($this->year == 'all' ? 'Semua Tahun' : $this->year);

        // 3. Lempar semua data $stats dan $periode ke view
        return view('admin.earnings.excel', array_merge(compact('periode'), $stats));
    }

    // FORMAT CURRENCY / UANG UNTUK KOLOM E (Nominal)
    public function columnFormats(): array
    {
        return [
            'E' => '#,##0', // Format angka (ribuan) standar Excel agar bisa dijumlahkan otomatis pakai rumus SUM di Excel-nya
        ];
    }

    // STYLING BARIS HEADER EXCEL
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 14]], // Judul Rekap
            2    => ['font' => ['bold' => true]],               // Nama Tim
            3    => ['font' => ['bold' => true]],               // Periode
        ];
    }
}