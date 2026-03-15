<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Kolom untuk menandakan apakah fee Aplikasi sudah ditransfer ke Programmer
            $table->boolean('is_programmer_paid')->default(false)->after('programmer_id');
            // Kolom untuk menandakan apakah fee Naskah sudah ditransfer ke Writer
            $table->boolean('is_writer_paid')->default(false)->after('writer_id');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['is_programmer_paid', 'is_writer_paid']);
        });
    }
};