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
        // CUKUP 1 KALI PEMANGGILAN SAJA
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end');
            $table->string('room');
            $table->foreignId('examiner_1_id')->constrained('users'); // Penguji 1
            $table->foreignId('examiner_2_id')->constrained('users'); // Penguji 2
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};