<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuezGrade extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'user_id', 'user_grade'];
    /**
     * Get the user that owns the UserQuezGrade
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
