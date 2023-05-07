<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubjectMatterial extends Model
{
    use HasFactory;
    protected $fillable = ['subject_id', 'name', 'details', 'src'];
    /**
     * Get all of the comments for the SubjectMatterial
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
