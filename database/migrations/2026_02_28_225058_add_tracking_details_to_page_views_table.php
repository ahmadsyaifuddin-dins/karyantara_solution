<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->string('browser')->nullable()->after('ip_address');
            $table->string('os')->nullable()->after('browser');
            $table->string('device_type')->nullable()->after('os'); // Desktop / Mobile
            $table->string('location')->nullable()->after('device_type'); // Kota, Negara
            $table->string('isp')->nullable()->after('location'); // Provider (Telkomsel, Biznet, dll)
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropColumn(['browser', 'os', 'device_type', 'location', 'isp']);
        });
    }
};
