<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'department', 'description', 'parent_id', 'icon', 'color_bg', 'color_text'
    ];

    // Relasi ke Atasan (1 Atasan)
    public function parent()
    {
        return $this->belongsTo(Position::class, 'parent_id');
    }

    // Relasi ke Bawahan (Banyak Bawahan)
    public function children()
    {
        return $this->hasMany(Position::class, 'parent_id');
    }

    // Relasi ke User (Siapa saja yang menjabat posisi ini)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}