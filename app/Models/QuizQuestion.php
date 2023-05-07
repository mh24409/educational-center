<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id','question','choice_a','choice_b','choice_c','choice_d','correct_answer','grade'];
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
    /**
     * Get all of the comments for the QuizQuestion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function useranswers(): HasMany
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }
    
}
