<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuestionAnswer extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_questions_id', 'user_id', 'user_answer', 'user_grade'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_questions_id',);
    }
}
