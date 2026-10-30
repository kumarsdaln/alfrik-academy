<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = ['course_module_id', 'title', 'summary', 'type', 'duration_seconds', 'video_url', 'body', 'resource_path', 'is_preview', 'position'];
    protected function casts(): array
    {
        return ['is_preview' => 'boolean'];
    }
    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }
}
