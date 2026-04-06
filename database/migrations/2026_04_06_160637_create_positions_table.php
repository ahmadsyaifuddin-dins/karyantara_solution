<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: 'CTO', 'Frontend Developer'
            $table->string('department')->nullable(); // Contoh: 'Kerajaan Teknologi'
            $table->text('description')->nullable();
            // Self-referencing FK untuk membentuk Hirarki (Bawahan -> Atasan)
            $table->foreignId('parent_id')->nullable()->constrained('positions')->nullOnDelete(); 
            $table->string('icon')->nullable(); // Contoh: 'fa-solid fa-microchip'
            $table->string('color_bg')->nullable(); // Contoh: 'bg-amber-500'
            $table->string('color_text')->nullable(); // Contoh: 'text-amber-500'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};