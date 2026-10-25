<?php

namespace App\Models;

use App\Models\Concerns\ResolvesPublicImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insight extends Model
{
    use ResolvesPublicImages;
    protected $fillable = ['author_id', 'title', 'slug', 'type', 'category', 'excerpt', 'body', 'cover_image', 'survey_url', 'survey_questions', 'reading_minutes', 'status', 'published_at'];

    protected function casts(): array
    {
        return ['published_at' => 'datetime', 'survey_questions' => 'array'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function surveyResponses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
