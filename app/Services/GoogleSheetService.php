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
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->addScope(Sheets::SPREADSHEETS);

        $this->service = new Sheets($this->client);
        $this->spreadsheetId = env('GOOGLE_SHEET_ID');
    }

    // FUNGSI HELPER BARU: Mewarnai 1 baris secara spesifik
    private function applyRowColor($sheetName, $rowIndex, $isLunas)
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

            if ($isLunas) {
                // Sesuai Request: Warna Hijau Murni (#00FF00)
                $bgColor = ['red' => 0, 'green' => 1, 'blue' => 0];
            } else {
                // Putih Bersih
                $bgColor = ['red' => 1, 'green' => 1, 'blue' => 1];
            }

            $request = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    // endColumnIndex dinaikkan ke 20 untuk mencakup tambahan kolom 'NO'
                    'range' => ['sheetId' => $sheetId, 'startRowIndex' => $rowIndex - 1, 'endRowIndex' => $rowIndex, 'startColumnIndex' => 0, 'endColumnIndex' => 20],
                    'cell' => ['userEnteredFormat' => ['backgroundColor' => $bgColor]],
                    'fields' => 'userEnteredFormat.backgroundColor'
                ]
            ]);

            $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest(['requests' => [$request]]);
            $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);

        } catch (\Exception $e) {
            Log::error('Gagal update warna baris: '.$e->getMessage());
        }
    }

    public function appendData($range, $values)
    {
        try {
            $body = new ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'USER_ENTERED'];

            $response = $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, $params);

            // LOGIKA PINTAR: Ngitung kolom dari belakang agar kebal pergeseran
            $updatedRange = $response->getUpdates()->getUpdatedRange();
            if (preg_match('/!A(\d+)/', $updatedRange, $matches)) {
                $rowIndex = (int)$matches[1];
                
                $c = count($values[0]);
                $totalHarga = isset($values[0][$c - 5]) ? (float)$values[0][$c - 5] : 0;
                $sisaTagihan = isset($values[0][$c - 3]) ? (float)$values[0][$c - 3] : 0;
                $isLunas = ($totalHarga > 0 && $sisaTagihan <= 0);
                
                $sheetName = explode('!', $range)[0];
                $this->applyRowColor($sheetName, $rowIndex, $isLunas);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('Gagal tambah data ke Google Sheet: '.$e->getMessage());
        }
    }

    public function updateDataById($sheetName, $id, $values)
    {
        try {
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $sheetName.'!B:B'); // Cek ID di Kolom B jika ada 'NO' di A. Jika ID tetap di A, ganti ke !A:A
            $rows = $response->getValues();
            $rowIndex = -1;

            if (!empty($rows)) {
                foreach ($rows as $index => $row) {
                    if (isset($row[0]) && $row[0] == $id) {
                        $rowIndex = $index + 1;
                        break;
                    }
                }
            }

            if ($rowIndex !== -1) {
                // Update ke rentang A sampai T (Karena ada 20 kolom)
                $updateRange = $sheetName.'!A'.$rowIndex.':T'.$rowIndex;
                $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
                $params = ['valueInputOption' => 'USER_ENTERED'];

                $response = $this->service->spreadsheets_values->update($this->spreadsheetId, $updateRange, $body, $params);

                $c = count($values[0]);
                $totalHarga = isset($values[0][$c - 5]) ? (float)$values[0][$c - 5] : 0;
                $sisaTagihan = isset($values[0][$c - 3]) ? (float)$values[0][$c - 3] : 0;
                $isLunas = ($totalHarga > 0 && $sisaTagihan <= 0);
                
                $this->applyRowColor($sheetName, $rowIndex, $isLunas);

                return $response;
            } else {
                $this->appendData($sheetName.'!A:T', $values);
            }

        } catch (\Exception $e) {
            Log::error('Gagal update data ke Google Sheet: '.$e->getMessage());
        }
    }

    public function clearRowById($sheetName, $id)
    {
        try {
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $sheetName.'!B:B'); 
            $rows = $response->getValues();

            if (!empty($rows)) {
                foreach ($rows as $index => $row) {
                    if (isset($row[0]) && $row[0] == $id) {
                        $rowIndex = $index + 1;
                        $clearRange = $sheetName.'!A'.$rowIndex.':T'.$rowIndex;

                        $this->service->spreadsheets_values->clear($this->spreadsheetId, $clearRange, new \Google\Service\Sheets\ClearValuesRequest());
                        $this->applyRowColor($sheetName, $rowIndex, false);
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Gagal hapus baris private: '.$e->getMessage());
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

            $clearRange = $sheetName.'!A1:T1000';
            $this->service->spreadsheets_values->clear($this->spreadsheetId, $clearRange, new \Google\Service\Sheets\ClearValuesRequest());

            $updateRange = $sheetName.'!A1';
            $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'USER_ENTERED'];
            $this->service->spreadsheets_values->update($this->spreadsheetId, $updateRange, $body, $params);

            $requests = [];

            // A. Format Header (0 sampai 20)
            $requests[] = new \Google\Service\Sheets\Request([
                'repeatCell' => [
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

            // B. Auto-Coloring Logic Pintar
            foreach ($values as $index => $row) {
                if ($index === 0) continue;

                $c = count($row);
                $totalHarga = isset($row[$c - 5]) ? (float)$row[$c - 5] : 0;
                $sisaTagihan = isset($row[$c - 3]) ? (float)$row[$c - 3] : 0;

                if ($totalHarga > 0 && $sisaTagihan <= 0) {
                    $bgColor = ['red' => 0, 'green' => 1, 'blue' => 0]; // #00FF00
                } else {
                    $bgColor = ['red' => 1, 'green' => 1, 'blue' => 1]; // Putih
                }

                $requests[] = new \Google\Service\Sheets\Request([
                    'repeatCell' => [
                        'range' => ['sheetId' => $sheetId, 'startRowIndex' => $index, 'endRowIndex' => $index + 1, 'startColumnIndex' => 0, 'endColumnIndex' => 20],
                        'cell' => ['userEnteredFormat' => ['backgroundColor' => $bgColor]],
                        'fields' => 'userEnteredFormat.backgroundColor',
                    ],
                ]);
            }

            if (!empty($requests)) {
                $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest(['requests' => $requests]);
                $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
            }

        } catch (\Exception $e) {
            Log::error('Gagal sync massal: '.$e->getMessage());
        }
    }
}