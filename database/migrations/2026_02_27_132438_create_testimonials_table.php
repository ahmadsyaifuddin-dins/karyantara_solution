<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_title')->nullable(); // nullable karena mungkin ada yang tidak punya title spesifik
            $table->text('testimonial');
            $table->tinyInteger('rating')->default(5); // Rating 1-5
            $table->string('profile_image')->nullable(); // nullable untuk menampung logika default avatar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
