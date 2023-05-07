<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCourse extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'course_id','attendance_number','absence_number','last_attend'];
/**
 * Get the user that owns the UserCourse
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
}
