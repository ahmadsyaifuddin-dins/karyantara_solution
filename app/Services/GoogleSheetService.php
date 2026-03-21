<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

class GoogleSheetService
{
    protected $client;

    protected $service;

    protected $spreadsheetId;

    public function __construct()
    {
        $this->client = new Client;

        // Pastikan path ini sesuai dengan lokasi credentials.json Anda
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->addScope(Sheets::SPREADSHEETS);

        $this->service = new Sheets($this->client);
        $this->spreadsheetId = env('GOOGLE_SHEET_ID');
    }

    // Fungsi untuk menambah baris baru (Create)
    public function appendData($range, $values)
    {
        try {
            $body = new ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'USER_ENTERED'];

            return $this->service->spreadsheets_values->append(
                $this->spreadsheetId,
                $range,
                $body,
                $params
            );
        } catch (\Exception $e) {
            Log::error('Gagal tambah data ke Google Sheet: '.$e->getMessage());
        }
    }

    public function updateDataById($sheetName, $id, $values)
    {
        try {
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $sheetName.'!A:A');
            $rows = $response->getValues();
            $rowIndex = -1;

            if (! empty($rows)) {
                foreach ($rows as $index => $row) {
                    if (isset($row[0]) && $row[0] == $id) {
                        $rowIndex = $index + 1;
                        break;
                    }
                }
            }

            if ($rowIndex !== -1) {
                // Update ke S menjadi T
                $updateRange = $sheetName . '!A' . $rowIndex . ':T' . $rowIndex;
                $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
                $params = ['valueInputOption' => 'USER_ENTERED'];

                return $this->service->spreadsheets_values->update($this->spreadsheetId, $updateRange, $body, $params);
            } else {
                $this->appendData($sheetName . '!A:T', $values);
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal update data ke Google Sheet: '.$e->getMessage());
        }
    }

    // FUNGSI BARU: Untuk menghapus/mengosongkan baris jika proyek jadi Private
    public function clearRowById($sheetName, $id)
    {
        try {
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $sheetName.'!A:A');
            $rows = $response->getValues();

            if (! empty($rows)) {
                foreach ($rows as $index => $row) {
                    if (isset($row[0]) && $row[0] == $id) {
                        $rowIndex = $index + 1;
                        $clearRange = $sheetName . '!A' . $rowIndex . ':T' . $rowIndex;

                        // Hapus teks di baris tersebut
                        $this->service->spreadsheets_values->clear(
                            $this->spreadsheetId,
                            $clearRange,
                            new \Google\Service\Sheets\ClearValuesRequest
                        );
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal hapus baris private di Google Sheet: '.$e->getMessage());
        }
    }

    public function syncAllData($sheetName, $values)
    {
        try {
            $sheet = $this->service->spreadsheets->get($this->spreadsheetId);
            $sheetId = 0;
            foreach ($sheet->getSheets() as $s) {
                if ($s->getProperties()->getTitle() == $sheetName) {
                    $sheetId = $s->getProperties()->getSheetId();
                    break;
                }
            }

            // Bersihkan A1 sampai S1000
            $clearRange = $sheetName . '!A1:T1000';
            $this->service->spreadsheets_values->clear($this->spreadsheetId, $clearRange, new \Google\Service\Sheets\ClearValuesRequest);

            $updateRange = $sheetName . '!A1';
            $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'USER_ENTERED'];
            $this->service->spreadsheets_values->update($this->spreadsheetId, $updateRange, $body, $params);

            $summaryValues = [
                ['TOTAL PENDAPATAN', 'TOTAL TERBAYARKAN', 'TOTAL SISA TAGIHAN'],
                ['=SUM(P2:P)', '=SUM(Q2:Q)', '=SUM(R2:R)']
            ];
            $summaryBody = new \Google\Service\Sheets\ValueRange(['values' => $summaryValues]);
            // Taruh di kolom V, W, X baris 1 & 2
            $this->service->spreadsheets_values->update($this->spreadsheetId, $sheetName . '!V1:X2', $summaryBody, ['valueInputOption' => 'USER_ENTERED']);


            $requests = [];

            // A. Format Header Utama & Header Summary
            $requests[] = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    // UPDATE 5: endColumnIndex jadi 20 (Untuk Kolom A-T)
                    'range' => ['sheetId' => $sheetId, 'startRowIndex' => 0, 'endRowIndex' => 1, 'startColumnIndex' => 0, 'endColumnIndex' => 20],
                    'cell' => [
                        'userEnteredFormat' => [
                            'backgroundColor' => ['red' => 30 / 255, 'green' => 41 / 255, 'blue' => 59 / 255],
                            'textFormat' => ['foregroundColor' => ['red' => 1, 'green' => 1, 'blue' => 1], 'bold' => true],
                        ],
                    ],
                    'fields' => 'userEnteredFormat(backgroundColor,textFormat)',
                ],
            ]);

            // Format Header Kotak Rekap (V1 - X1)
            $requests[] = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    'range' => ['sheetId' => $sheetId, 'startRowIndex' => 0, 'endRowIndex' => 1, 'startColumnIndex' => 21, 'endColumnIndex' => 24],
                    'cell' => [
                        'userEnteredFormat' => [
                            'backgroundColor' => ['red' => 245 / 255, 'green' => 158 / 255, 'blue' => 11 / 255], // Warna Amber
                            'textFormat' => ['foregroundColor' => ['red' => 1, 'green' => 1, 'blue' => 1], 'bold' => true],
                        ],
                    ],
                    'fields' => 'userEnteredFormat(backgroundColor,textFormat)',
                ],
            ]);

            // B. Format Mata Uang (Kolom P=15, Q=16, R=17) DAN Kotak Rekap (V2-X2)
            $requests[] = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    'range' => ['sheetId' => $sheetId, 'startRowIndex' => 1, 'startColumnIndex' => 15, 'endColumnIndex' => 18],
                    'cell' => ['userEnteredFormat' => ['numberFormat' => ['type' => 'CURRENCY', 'pattern' => 'Rp #,##0']]],
                    'fields' => 'userEnteredFormat.numberFormat',
                ],
            ]);
            $requests[] = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    'range' => ['sheetId' => $sheetId, 'startRowIndex' => 1, 'endRowIndex' => 2, 'startColumnIndex' => 21, 'endColumnIndex' => 24],
                    'cell' => [
                        'userEnteredFormat' => [
                            'numberFormat' => ['type' => 'CURRENCY', 'pattern' => 'Rp #,##0'],
                            'textFormat' => ['bold' => true] // Bold angkanya
                        ]
                    ],
                    'fields' => 'userEnteredFormat(numberFormat,textFormat)',
                ],
            ]);

            // C. Logic Warna Hijau
            foreach ($values as $index => $row) {
                if ($index === 0) continue;

                // Index 15 = Total Harga, Index 17 = Sisa Tagihan
                $totalHarga = isset($row[15]) ? (float) $row[15] : 0;
                $sisaTagihan = isset($row[17]) ? (float) $row[17] : 0;

                if ($totalHarga > 0 && $sisaTagihan <= 0) {
                    $requests[] = new \Google\Service\Sheets\Request([
                        'repeatCell' => [
                            // UPDATE 6: endColumnIndex jadi 20
                            'range' => ['sheetId' => $sheetId, 'startRowIndex' => $index, 'endRowIndex' => $index + 1, 'startColumnIndex' => 0, 'endColumnIndex' => 20],
                            'cell' => ['userEnteredFormat' => ['backgroundColor' => ['red' => 212 / 255, 'green' => 237 / 255, 'blue' => 218 / 255]]],
                            'fields' => 'userEnteredFormat.backgroundColor',
                        ],
                    ]);
                }
            }

            if (! empty($requests)) {
                $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest(['requests' => $requests]);
                $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal sync massal ke Google Sheet: '.$e->getMessage());
        }
    }
}
