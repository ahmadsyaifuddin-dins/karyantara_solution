<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Mengubah tipe kolom dari ENUM menjadi STRING agar fleksibel
            $table->string('skripsi_package', 100)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Rollback opsional, biarkan string saja tidak masalah
        });
    }
};