<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('revision_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('title'); // Contoh: "Revisi Pasca Sempro"
            $table->enum('type', ['app', 'naskah', 'keduanya']);
            $table->enum('status', ['backlog', 'in_progress', 'waiting', 'done'])->default('backlog');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0); // Untuk urutan di Kanban
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revision_tickets');
    }
};