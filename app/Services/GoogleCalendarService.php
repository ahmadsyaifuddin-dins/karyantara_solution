<?php

namespace App\Services;

use App\Models\Meeting;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class GoogleCalendarService
{
    protected $client;

    protected $service;

    protected $calendarId;

    public function __construct()
    {
        $this->client = new Google_Client;
        // Path sudah benar sesuai milik Anda
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);

        $this->service = new Google_Service_Calendar($this->client);
        $this->calendarId = env('GOOGLE_CALENDAR_ID');
    }

    /**
     * Membentuk format data event untuk dikirim ke Google
     */
    private function prepareEventData(Meeting $meeting)
    {
        // 1. Modifikasi Judul berdasarkan Status
        $titlePrefix = '';
        $colorId = '1'; // Default Biru/Lavender

        if ($meeting->status === 'Ongoing') {
            $titlePrefix = '[BERLANGSUNG] ';
            $colorId = '5'; // Kuning (Banana)
        } elseif ($meeting->status === 'Completed') {
            $titlePrefix = '[SELESAI] ';
            $colorId = '10'; // Hijau (Basil)
        } elseif ($meeting->status === 'Canceled') {
            $titlePrefix = '[DIBATALKAN] ';
            $colorId = '11'; // Merah (Tomato)
        }

        // 2. Deskripsi berisi ringkasan & link (jika ada)
        $description = "Jenis: {$meeting->type}\n\nRingkasan:\n{$meeting->agenda_summary}";
        if ($meeting->maps_link) {
            $description .= "\n\nLink Maps: {$meeting->maps_link}";
        }

        return new Google_Service_Calendar_Event([
            'summary' => $titlePrefix.$meeting->title,
            'location' => $meeting->location,
            'description' => $description,
            'colorId' => $colorId,
            'start' => [
                'dateTime' => $meeting->start_time->toIso8601String(),
                'timeZone' => env('APP_TIMEZONE', 'Asia/Makassar'),
            ],
            'end' => [
                'dateTime' => $meeting->end_time->toIso8601String(),
                'timeZone' => env('APP_TIMEZONE', 'Asia/Makassar'),
            ],
            // ATTENDEES DIHAPUS KARENA BOT DILARANG MENGINVITE ORANG LAIN TANPA WORKSPACE

            // Supaya notifikasi popup kalender nyala 30 menit sebelum rapat
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'popup', 'minutes' => 30],
                ],
            ],
        ]);
    }

    public function createEvent(Meeting $meeting)
    {
        $event = $this->prepareEventData($meeting);
        // Hapus ['sendUpdates' => 'all'] karena tidak ada yang di-invite
        $createdEvent = $this->service->events->insert($this->calendarId, $event);

        return $createdEvent->getId();
    }

    public function updateEvent(Meeting $meeting)
    {
        if (! $meeting->google_event_id) {
            return;
        }

        $event = $this->prepareEventData($meeting);

        if ($meeting->status === 'Canceled') {
            $event->setStatus('cancelled');
        }

        // Hapus ['sendUpdates' => 'all']
        $this->service->events->update($this->calendarId, $meeting->google_event_id, $event);
    }

    public function deleteEvent($eventId)
    {
        if (! $eventId) {
            return;
        }

        try {
            // Hapus ['sendUpdates' => 'all']
            $this->service->events->delete($this->calendarId, $eventId);
        } catch (\Exception $e) {
            // Abaikan jika event sudah terhapus manual di Google
        }
    }
}
