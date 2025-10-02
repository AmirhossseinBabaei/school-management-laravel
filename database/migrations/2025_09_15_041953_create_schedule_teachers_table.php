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
        Schema::create('schedule_teachers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade')->onUpdate('cascade');

            $table->enum('date_week', ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Thursday', 'Wednesday', 'Friday']);

            $table->time('start_time');
            $table->time('finish_time');

            $table->enum('mode', ['online', 'offline'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_teachers');
    }
};
