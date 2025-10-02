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
        Schema::create('cms_contents_schools', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('published_by_user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('rejected_by_user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');

            $table->string('title');
            $table->text('body');

            $table->enum('type', ['news', 'post']);

            $table->enum('status', ['draft', 'published', 'rejected'])->default('draft');

            $table->timestamp('publish_at')->nullable();
            $table->timestamp('reject_at')->nullable();

            $table->string('uuid')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_contents_schools');
    }
};
