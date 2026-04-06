<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       
        'position_id',
        'autoplay_music',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel Positions
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    
    // Helper function untuk cek role (Opsional tapi sangat berguna nantinya)
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }
}