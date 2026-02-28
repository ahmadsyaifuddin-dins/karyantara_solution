<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Kolom Kepemilikan (Untuk fitur Manajemen Admin Bersama/Sendiri)
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_shared')->default(true); // 1 = Kelola Bersama, 0 = Private

            // Profil Klien
            $table->enum('client_type', ['mahasiswa', 'umum'])->default('mahasiswa');
            $table->string('client_name');

            // Khusus Mahasiswa (Dibuat nullable karena klien 'Umum' tidak punya ini)
            $table->string('npm')->nullable();
            $table->string('class_name')->nullable();
            $table->string('dospem_1')->nullable();
            $table->string('dospem_2')->nullable();
            $table->string('skripsi_title')->nullable();

            // Detail Pekerjaan
            $table->text('project_description'); // Apa yang kita kerjakan
            $table->string('status')->default('Pending'); // Status: Pending, Progress, Revisi, Selesai
            $table->text('revision_notes')->nullable(); // Catatan revisi

            // Finansial / Keuangan
            $table->bigInteger('net_income')->default(0); // Pendapatan Bersih (Total Harga Fix Karyantara)
            $table->bigInteger('paid_amount')->default(0); // Sudah Terbayar
            $table->enum('payment_method', ['cash', 'transfer'])->default('transfer');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
