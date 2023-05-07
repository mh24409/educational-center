<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHomework extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'homework_id', 'src'];
}
