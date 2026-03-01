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
            // Tambahkan setelah kolom email
            $table->string('phone_number', 20)->unique()->after('email');
            // Tambahkan setelah ip_address
            $table->text('user_agent')->nullable()->after('ip_address');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'user_agent']);
        });
    }
};
