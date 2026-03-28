<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiCalculationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'target_item',
        'target_price',
        'financial_snapshot',
        'ai_advice',
        'model_used',
    ];

    protected $casts = [
        'financial_snapshot' => 'array', // Biar otomatis jadi array saat dipanggil
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}