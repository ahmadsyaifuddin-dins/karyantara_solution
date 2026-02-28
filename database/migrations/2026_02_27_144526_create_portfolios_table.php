<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama proyek
            $table->string('category'); // Kategori (Web, Mobile, UI/UX, dll)
            $table->text('description'); // Deskripsi proyek
            $table->string('image'); // Gambar wajib ada untuk portofolio
            $table->string('client_name')->nullable(); // Nama klien (opsional)
            $table->string('project_url')->nullable(); // Link ke aplikasi/web jika ada (opsional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
