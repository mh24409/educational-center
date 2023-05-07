<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Homework extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'start_date', 'end_date', 'src'];
    /**
     * Get the user that owns the Homework
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_homework');
    }
}
