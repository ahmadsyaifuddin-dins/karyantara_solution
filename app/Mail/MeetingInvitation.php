<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;

    public $attendeeEmail;

    public function __construct(Meeting $meeting, $attendeeEmail)
    {
        $this->meeting = $meeting;
        $this->attendeeEmail = $attendeeEmail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undangan Rapat: '.$this->meeting->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.meeting_invitation', // Kita akan buat view ini nanti
        );
    }

    public function attachments(): array
    {
        // Panggil fungsi pembuat ICS dan lampirkan ke email
        $icsContent = $this->generateIcs();

        return [
            Attachment::fromData(fn () => $icsContent, 'invite.ics')
                ->withMime('text/calendar; charset=UTF-8; method=REQUEST'), // Header wajib agar Gmail memunculkan tombol Yes/No
        ];
    }

    /**
     * Mesin pembuat format file .ics standar internasional
     */
    private function generateIcs()
    {
        // Wajib dikonversi ke UTC (Z) agar Google Calendar tidak salah hitung zona waktu
        $start = $this->meeting->start_time->copy()->setTimezone('UTC')->format('Ymd\THis\Z');
        $end = $this->meeting->end_time->copy()->setTimezone('UTC')->format('Ymd\THis\Z');
        $now = now()->setTimezone('UTC')->format('Ymd\THis\Z');

        // UID unik agar kalau rapat di-edit/batal, kalender user tahu event mana yang diubah
        $uid = 'karyantara_meeting_'.$this->meeting->id.'@karyantarasolution.com';

        // Membersihkan teks dari enter agar tidak merusak format ICS
        $summary = str_replace(["\r", "\n"], ' ', $this->meeting->title);
        $description = str_replace(["\r", "\n"], '\\n', "Agenda:\n{$this->meeting->agenda_summary}");
        $location = str_replace(["\r", "\n"], ' ', $this->meeting->location);
        $organizerEmail = config('mail.from.address', 'karyantarasolution@gmail.com');

        // Merakit teks ICS (wajib menggunakan \r\n untuk pindah baris)
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//Karyantara Solution//MoM System//EN\r\n";
        $ics .= "METHOD:REQUEST\r\n"; // Penting: Ini yang bikin muncul tombol RSVP
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "UID:{$uid}\r\n";
        $ics .= "DTSTAMP:{$now}\r\n";
        $ics .= "DTSTART:{$start}\r\n";
        $ics .= "DTEND:{$end}\r\n";
        $ics .= "SUMMARY:{$summary}\r\n";
        $ics .= "DESCRIPTION:{$description}\r\n";
        $ics .= "LOCATION:{$location}\r\n";
        $ics .= "ORGANIZER;CN=\"Karyantara Solution\":mailto:{$organizerEmail}\r\n";
        $ics .= "ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE:mailto:{$this->attendeeEmail}\r\n";
        $ics .= "END:VEVENT\r\n";
        $ics .= 'END:VCALENDAR';

        return $ics;
    }
}
