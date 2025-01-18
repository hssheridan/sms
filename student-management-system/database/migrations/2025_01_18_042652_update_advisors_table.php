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
        Schema::table('advisors', function (Blueprint $table) {
            $table->foreignId('course_id')->nullable()->constrained('courses');
            $table->foreignId('student_id')->nullable()->constrained('students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisors', function (Blueprint $table) {
            $table->dropColumn('course_id');
            $table->dropColumn('student_id');
        });
    }
};
