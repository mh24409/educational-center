<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    use HasFactory;
    protected $fillable = [
        'level_name'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
