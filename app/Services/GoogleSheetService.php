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
                // Update ke rentang A sampai S
                $updateRange = $sheetName.'!A'.$rowIndex.':S'.$rowIndex;
                $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
                $params = ['valueInputOption' => 'USER_ENTERED'];

                return $this->service->spreadsheets_values->update($this->spreadsheetId, $updateRange, $body, $params);
            } else {
                // Jika tidak ada di Sheet (misal: baru diubah dari Private ke Public), tambahkan!
                $this->appendData($sheetName.'!A:S', $values);
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
                        $clearRange = $sheetName.'!A'.$rowIndex.':S'.$rowIndex;

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
            $clearRange = $sheetName.'!A1:S1000';
            $this->service->spreadsheets_values->clear($this->spreadsheetId, $clearRange, new \Google\Service\Sheets\ClearValuesRequest);

            $updateRange = $sheetName.'!A1';
            $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'USER_ENTERED'];
            $this->service->spreadsheets_values->update($this->spreadsheetId, $updateRange, $body, $params);

            $requests = [];

            // A. Format Header (endColumnIndex jadi 19)
            $requests[] = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    'range' => ['sheetId' => $sheetId, 'startRowIndex' => 0, 'endRowIndex' => 1, 'startColumnIndex' => 0, 'endColumnIndex' => 19],
                    'cell' => [
                        'userEnteredFormat' => [
                            'backgroundColor' => ['red' => 30 / 255, 'green' => 41 / 255, 'blue' => 59 / 255],
                            'textFormat' => ['foregroundColor' => ['red' => 1, 'green' => 1, 'blue' => 1], 'bold' => true],
                        ],
                    ],
                    'fields' => 'userEnteredFormat(backgroundColor,textFormat)',
                ],
            ]);

            // B. Format Mata Uang (Geser ke Kolom O=14, P=15, Q=16)
            $requests[] = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    'range' => ['sheetId' => $sheetId, 'startRowIndex' => 1, 'startColumnIndex' => 14, 'endColumnIndex' => 17],
                    'cell' => ['userEnteredFormat' => ['numberFormat' => ['type' => 'CURRENCY', 'pattern' => 'Rp #,##0']]],
                    'fields' => 'userEnteredFormat.numberFormat',
                ],
            ]);

            // C. Logic Warna Hijau
            foreach ($values as $index => $row) {
                if ($index === 0) {
                    continue;
                }

                // Index 14 = Total Harga, Index 16 = Sisa Tagihan
                $totalHarga = isset($row[14]) ? (float) $row[14] : 0;
                $sisaTagihan = isset($row[16]) ? (float) $row[16] : 0;

                if ($totalHarga > 0 && $sisaTagihan <= 0) {
                    $requests[] = new \Google\Service\Sheets\Request([
                        'repeatCell' => [
                            'range' => ['sheetId' => $sheetId, 'startRowIndex' => $index, 'endRowIndex' => $index + 1, 'startColumnIndex' => 0, 'endColumnIndex' => 19],
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
