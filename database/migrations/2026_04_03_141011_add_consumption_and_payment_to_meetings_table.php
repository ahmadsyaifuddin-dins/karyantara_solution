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
    Schema::table('meetings', function (Blueprint $table) {
        $table->bigInteger('consumption_cost')->nullable()->default(0)->after('location');
        $table->string('payment_method')->nullable()->after('consumption_cost');
    });
    }

public function down(): void
    {
    Schema::table('meetings', function (Blueprint $table) {
        $table->dropColumn(['consumption_cost', 'payment_method']);
    });
    }
};
