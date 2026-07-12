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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('examiner_id')->constrained('users'); // Dosen yang menilai
            $table->integer('score_presentation')->default(0);
            $table->integer('score_material')->default(0);
            $table->integer('score_qna')->default(0);
            $table->decimal('total_score', 5, 2)->default(0);
            $table->text('revision_notes')->nullable(); // Catatan revisi untuk mahasiswa
            $table->boolean('is_locked')->default(false); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};