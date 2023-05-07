<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username', 'phone', 'birthdate', 'school', 'email', 'password', 'level_id', 'image'
    ];
    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        return  '/uploads/images/users/' . $this->image;
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_courses')->withPivot('attendance_number', 'absence_number','last_attend');
    }
    public function answers(): HasMany
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }
    public function grades()
    {
        return $this->hasMany(UserQuezGrade::class);
    }
    public function homeworks(): BelongsToMany
    {
        return $this->belongsToMany(Homework::class, 'user_homework');
    }

    public function teacherFeedbacks(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_user_feedback');
    }
}
