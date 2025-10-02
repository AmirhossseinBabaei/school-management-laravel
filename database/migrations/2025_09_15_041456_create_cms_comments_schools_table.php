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
        Schema::create('cms_comments_schools', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('content_id')->constrained('cms_contents_schools')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('cms_comments_schools')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('published_by_user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('rejected_by_user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade')->onUpdate('cascade');

            $table->text('body');

            $table->enum('status', ['draft', 'published', 'rejected'])->default('draft');

            $table->timestamp('publish_at')->nullable();
            $table->timestamp('reject_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_comments_schools');
    }
};
