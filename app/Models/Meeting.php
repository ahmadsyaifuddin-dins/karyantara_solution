<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'type',
        'agenda_summary',
        'start_time',
        'end_time',
        'location',
        'maps_link',
        'status',
        'minutes_of_meeting',
        'action_items',
        'created_by',
        'documentation_file',
        'documentation_link',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Laravel 11 menggunakan method casts()
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'action_items' => 'array', // Otomatis convert JSON dari/ke Array
        ];
    }

    /**
     * Relasi ke pembuat agenda (User)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Fungsi On-The-Fly untuk update status otomatis
     */
    public static function updateAutomatedStatuses()
    {
        $now = now(); // Ini sudah otomatis mengikuti Asia/Makassar (WITA) berkat .env Anda

        // 1. Ubah ke "Ongoing"
        // Syarat: Status masih Scheduled, waktu mulai sudah lewat/sama, TAPI waktu selesai belum lewat.
        self::where('status', 'Scheduled')
            ->where('start_time', '<=', $now)
            ->where('end_time', '>', $now)
            ->update(['status' => 'Ongoing']);

        // 2. Ubah ke "Completed"
        // Syarat: Status Scheduled atau Ongoing, dan waktu selesainya sudah terlewati.
        // (Status 'Canceled' tidak dimasukkan ke sini, jadi akan diabaikan selamanya)
        self::whereIn('status', ['Scheduled', 'Ongoing'])
            ->where('end_time', '<=', $now)
            ->update(['status' => 'Completed']);
    }
}