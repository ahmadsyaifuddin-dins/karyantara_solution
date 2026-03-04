<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            // Kolom untuk melacak siapa yang melihat
            $table->string('visitor_type')->default('Guest')->after('ip_address'); // 'Guest' atau 'Admin'
            $table->string('visitor_name')->default('Anonim')->after('visitor_type'); // Nama admin atau 'Publik'
            
            // Kolom untuk raw data hp/device
            $table->text('raw_user_agent')->nullable()->after('isp'); 
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropColumn(['visitor_type', 'visitor_name', 'raw_user_agent']);
        });
    }
};