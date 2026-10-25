<?php

namespace App\Models;

use App\Models\Concerns\ResolvesPublicImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebinarEvent extends Model
{
    use ResolvesPublicImages;
    protected $fillable = [
        'title', 'slug', 'event_type', 'summary', 'description', 'cover_image', 'starts_at', 'timezone',
        'duration_minutes', 'host_name', 'host_title', 'meeting_url', 'replay_url', 'capacity',
        'price_minor', 'currency', 'status', 'published_at', 'created_by',
    ];

    protected function casts(): array
    {
        return ['starts_at' => 'immutable_datetime', 'published_at' => 'immutable_datetime'];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(WebinarRegistration::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
