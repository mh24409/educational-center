<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id', 'date', 'start_time', 'end_time', 'total_grade', 'details'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }
    public function user_grade()
    {
        return $this->hasMany(UserQuezGrade::class);
    }
}
