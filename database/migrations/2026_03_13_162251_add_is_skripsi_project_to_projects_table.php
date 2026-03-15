<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('skripsi_package', ['aplikasi', 'naskah', 'keduanya'])->nullable()->after('client_name');
            
            // Kita siapkan 2 slot ID untuk 2 peran yang berbeda
            $table->foreignId('programmer_id')->nullable()->after('admin_id')->constrained('users')->nullOnDelete(); // Untuk Abdan (Aplikasi)
            $table->foreignId('writer_id')->nullable()->after('programmer_id')->constrained('users')->nullOnDelete(); // Untuk Ahmad (Naskah)
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['programmer_id']);
            $table->dropForeign(['writer_id']);
            $table->dropColumn(['programmer_id', 'writer_id', 'skripsi_package']);
        });
    }
};