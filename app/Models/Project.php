<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'is_shared',
        'client_type',
        'client_name',
        'npm',
        'class_name',
        'dospem_1',
        'dospem_2',
        'skripsi_title',
        'project_description',
        'status',
        'revision_notes',
        'net_income',
        'paid_amount',
        'payment_method',
    ];

    /**
     * Relasi ke tabel users (Admin yang memegang project)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Accessor Cerdas: Menghitung Sisa Pembayaran Otomatis
     * Cara panggil nanti di Blade: $project->remaining_amount
     */
    public function getRemainingAmountAttribute()
    {
        return $this->net_income - $this->paid_amount;
    }

    /**
     * Accessor Cerdas: Mengecek apakah sudah lunas
     * Cara panggil nanti di Blade: $project->is_paid_off
     */
    public function getIsPaidOffAttribute()
    {
        return $this->paid_amount >= $this->net_income;
    }
}
