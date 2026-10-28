<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->after('role')->constrained('users')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->after('teacher_id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['teacher_id', 'parent_id']);
        });
    }
};
