<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('disciplinary_records', function (Blueprint $table) {
            if (!Schema::hasColumn('disciplinary_records', 'type')) {
                $table->string('type', 20)->default('positive')->after('severity');
            }
            if (!Schema::hasColumn('disciplinary_records', 'score')) {
                $table->decimal('score', 5, 2)->nullable()->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('disciplinary_records', function (Blueprint $table) {
            if (Schema::hasColumn('disciplinary_records', 'score')) {
                $table->dropColumn('score');
            }
            if (Schema::hasColumn('disciplinary_records', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};


