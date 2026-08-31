<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'date_of_birth',
        'class_level',
        'school_origin',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function registration(): HasOne
    {
        return $this->hasOne(Registration::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function activeRegistration(): HasOne
    {
        return $this->hasOne(Registration::class)->where('status', 'terverifikasi');
    }

    public function parent(): HasOneThrough
    {
        return $this->hasOneThrough(
            ParentModel::class,
            Registration::class,
            'student_id',  // FK on registrations
            'id',          // FK on parents
            'id',          // local key on students
            'parent_id'    // local key on registrations
        );
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function progressReports(): HasMany
    {
        return $this->hasMany(ProgressReport::class);
    }

    public function getClassLevelLabelAttribute(): string
    {
        return match($this->class_level) {
            'tk_kecil' => 'TK Kecil',
            'tk_besar' => 'TK Besar',
            'sd_1' => 'SD Kelas 1',
            'sd_2' => 'SD Kelas 2',
            'sd_3' => 'SD Kelas 3',
            default => $this->class_level,
        };
    }
}
