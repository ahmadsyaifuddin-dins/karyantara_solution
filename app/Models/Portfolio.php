<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    // Hapus 'image' dari sini
    protected $fillable = [
        'title',
        'category',
        'description',
        'client_name',
        'project_url',
    ];

    // Tambahkan Relasi One-to-Many
    public function images()
    {
        return $this->hasMany(PortfolioImage::class);
    }

    // Helper untuk mengambil Thumbnail (Gambar Utama)
    public function getThumbnailAttribute()
    {
        // Cari yang is_thumbnail = 1, jika gak ada ambil gambar pertama, jika kosong kembalikan null
        $thumbnail = $this->images()->where('is_thumbnail', true)->first();

        return $thumbnail ? $thumbnail->image : optional($this->images()->first())->image;
    }
}
