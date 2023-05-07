<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'level_id', 'teacher_id', 'details'
    ];
    /**
     * Get the user that owns the subject
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(level::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function course()
    {
        return $this->hasOne(Course::class);
    }
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
    public function matterials(): HasMany
    {
        return $this->hasMany(SubjectMatterial::class);
    }
}
