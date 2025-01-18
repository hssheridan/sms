<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = ['name', 'advisor_id'];

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(Advisor::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}
