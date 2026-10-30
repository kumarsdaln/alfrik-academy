<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'assignment_id',
    'user_id',
    'content',
    'file_path',
    'status',
    'score',
    'feedback',
    'graded_by',
    'submitted_at',
    'graded_at',
])]
class AssignmentSubmission extends Model
{
    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'submitted_at' => 'immutable_datetime',
            'graded_at' => 'immutable_datetime',
        ];
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}