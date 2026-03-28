<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_calculation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete(); // Siapa admin yang request
            $table->string('target_item'); // Contoh: "Laptop ASUS TUF"
            $table->decimal('target_price', 15, 2)->nullable(); // Estimasi harga (bisa null jika user minta AI menebak)
            $table->json('financial_snapshot'); // Simpan json { total_cair: xx, total_piutang: xx }
            $table->longText('ai_advice'); // Saran panjang lebar dari Groq
            $table->string('model_used'); // Contoh: "llama3-8b-8192"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_calculation_histories');
    }
};