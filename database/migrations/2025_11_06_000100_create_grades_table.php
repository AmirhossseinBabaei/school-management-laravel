<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('term_id')->nullable();
            $table->decimal('score', 5, 2);
            $table->string('description')->nullable();
            $table->date('graded_at')->nullable();
            $table->unsignedBigInteger('graded_by_user_id');
            $table->timestamps();

            $table->index(['school_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};


