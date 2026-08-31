<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'period',
        'current_stage',
        'reading_skill',
        'writing_skill',
        'mastered_stages',
        'attendance_summary',
        'progress_narrative',
        'recommendations',
        'teacher_notes',
        'pdf_path',
        'created_by',
    ];

    protected $casts = [
        'mastered_stages' => 'array',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
