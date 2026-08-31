<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('period'); // e.g. "Agustus 2026"
            $table->string('current_stage'); // e.g. "Tahap 3 - Membaca Kata"
            $table->string('reading_skill')->nullable();
            $table->string('writing_skill')->nullable();
            $table->json('mastered_stages')->nullable();
            $table->string('attendance_summary')->nullable();
            $table->text('progress_narrative')->nullable();
            $table->text('recommendations')->nullable();
            $table->text('teacher_notes')->nullable();
            $table->string('pdf_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_reports');
    }
};
