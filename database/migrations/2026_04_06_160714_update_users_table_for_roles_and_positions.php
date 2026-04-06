<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('admin')->after('email');
            $table->foreignId('position_id')->nullable()->after('role')->constrained('positions')->nullOnDelete();
            
            // Hapus kolom lama karena sudah di-handle oleh tabel positions
            $table->dropColumn(['position', 'department']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->dropForeign(['position_id']);
            $table->dropColumn(['role', 'position_id']);
        });
    }
};