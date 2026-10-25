<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LiveSession extends Model
{
    protected $fillable = [
        'cohort_id', 'lesson_id', 'teacher_id', 'title', 'description', 'starts_at',
        'duration_minutes', 'provider', 'join_url', 'recording_url', 'status',
    ];

    protected function casts(): array
    {
        return ['starts_at' => 'immutable_datetime'];
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(SessionAttendance::class);
    }
}
