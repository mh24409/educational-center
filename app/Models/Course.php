<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'details', 'firstdaytime', 'firstday', 'seconddaytime', 'secondday', 'image', 'no_of_students', 'no_of_avilables', 'subject_id', 'start_date', 'end_date', 'status'
    ];
    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        return  URL::to('/uploads/images/courses/') . '/' . $this->image;
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses')->withPivot('attendance_number', 'absence_number', 'last_attend');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function homeworks(): HasMany
    {
        return $this->hasMany(Homework::class);
    }
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
