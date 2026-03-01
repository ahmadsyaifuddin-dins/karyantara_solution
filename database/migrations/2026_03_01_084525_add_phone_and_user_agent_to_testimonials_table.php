<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Cek apakah kolom phone_number sudah ada
            if (! Schema::hasColumn('testimonials', 'phone_number')) {
                $table->string('phone_number', 20)->unique()->after('email');
            }

            // Cek apakah kolom user_agent sudah ada
            if (! Schema::hasColumn('testimonials', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'user_agent']);
        });
    }
};
