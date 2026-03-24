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
}