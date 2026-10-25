<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebinarRegistration extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['registered_at' => 'immutable_datetime', 'paid_at' => 'immutable_datetime', 'expires_at' => 'immutable_datetime'];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(WebinarEvent::class, 'webinar_event_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
