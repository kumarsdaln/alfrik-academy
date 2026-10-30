<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'course_id',
    'name',
    'slug',
    'role',
    'cohort',
    'outcome',
    'quote',
    'story',
    'color',
    'status',
    'published_at',
])]
class LearnerStory extends Model
{
    protected function casts(): array
    {
        return [
            'published_at' => 'immutable_datetime',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published'
            && $this->published_at !== null;
    }
}