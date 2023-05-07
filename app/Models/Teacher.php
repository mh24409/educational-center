<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $fillable = [
        'username', 'phone', 'birthdate', 'school', 'email', 'password', 'about', 'image','rate'
    ];
    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        return  URL::to('/uploads/images/teachers/') . '/' . $this->image;
    }
    /**
     * Get all of the comments for the Teacher
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function userFeedbacks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'teacher_user_feedback');
    }
}
