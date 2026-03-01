<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // Hapus kolom image yang lama
            $table->dropColumn('image');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // Jika di-rollback, kembalikan kolom image
            $table->string('image')->nullable();
        });
    }
};
