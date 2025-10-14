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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->nullable()->constrained('schools');
            $table->foreignId('role_id')->nullable()->constrained('roles');

            $table->string('first_name', 100);
            $table->string('last_name', 100);

            $table->string('avatar_src')->nullable();
            $table->string('avatar_type')->nullable();

            $table->string('otp_code', 20)->nullable();
            $table->timestamp('otp_expire_at')->nullable();

            $table->string('phone', 20)->unique();

            $table->string('national_code',30)->unique();

            $table->string('email')->nullable();

            $table->string('password_hash');

            $table->enum('status', ['request', 'active', 'inactive'])->default('request');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
