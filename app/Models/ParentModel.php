<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'full_name',
        'whatsapp_number',
        'address',
    ];

    public function registration(): HasOne
    {
        return $this->hasOne(Registration::class, 'parent_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'parent_id');
    }

    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,
            Registration::class,
            'parent_id',
            'id',
            'id',
            'student_id'
        );
    }
}
