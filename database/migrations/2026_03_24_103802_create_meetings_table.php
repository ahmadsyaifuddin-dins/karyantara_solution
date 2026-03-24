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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            
            // Identitas & Tujuan
            $table->string('title');
            $table->string('type')->comment('Internal Board, Client Meeting, Project Sync, Evaluation');
            $table->text('agenda_summary');
            
            // Waktu & Lokasi
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location');
            $table->text('maps_link')->nullable();
            
            // Audit & Hasil
            $table->string('status')->default('Scheduled')->comment('Scheduled, Ongoing, Completed, Canceled');
            $table->longText('minutes_of_meeting')->nullable()->comment('Notulensi rapat');
            
            // Menyimpan action items dalam format JSON agar fleksibel jika nanti butuh struktur kompleks (siapa mengerjakan apa)
            $table->json('action_items')->nullable(); 
            
            // Relasi ke User (CEO / CTO)
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};