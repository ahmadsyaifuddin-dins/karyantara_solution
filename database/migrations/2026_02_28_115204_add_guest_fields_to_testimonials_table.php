<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('email')->nullable()->after('client_name');
            $table->boolean('is_approved')->default(false)->after('rating'); // Default: Pending (Manual)
            $table->string('ip_address', 45)->nullable()->after('is_approved');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['email', 'is_approved', 'ip_address']);
        });
    }
};
