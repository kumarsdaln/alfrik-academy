<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyResponse extends Model
{
    protected $fillable = ['insight_id', 'respondent_hash', 'answers', 'submitted_at'];

    protected function casts(): array
    {
        return ['answers' => 'array', 'submitted_at' => 'datetime'];
    }

    public function insight(): BelongsTo
    {
        return $this->belongsTo(Insight::class);
    }
}
