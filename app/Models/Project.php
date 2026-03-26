<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $casts = [
        'custom_team' => 'array', 
    ];

    protected $fillable = [
        'admin_id',
        'programmer_id',
        'is_programmer_paid',
        'writer_id',   
        'is_writer_paid',
        'skripsi_package',
        'client_type',
        'client_name',
        'npm',
        'class_name',
        'dospem_1',
        'dospem_2',
        'skripsi_title',
        'project_description',
        'status',
        'sort_order',
        'revision_notes',
        'app_price',
        'writer_price',
        'net_income',
        'paid_amount',
        'payment_method',
        'custom_team',
    ];

   /**
     * Relasi ke tabel users (Admin CS/Pengelola yang memegang project)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Relasi ke tabel users (Programmer / Developer Aplikasi)
     */
    public function programmer()
    {
        return $this->belongsTo(User::class, 'programmer_id');
    }

    /**
     * Relasi ke tabel users (Penulis Naskah Skripsi)
     */
    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id');
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
