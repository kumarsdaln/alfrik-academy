<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionAttendance extends Model
{
    protected $table = 'session_attendance';
    protected $fillable = ['live_session_id', 'user_id', 'joined_at', 'left_at', 'minutes_attended', 'status'];
    protected function casts(): array
    {
        return ['joined_at' => 'immutable_datetime', 'left_at' => 'immutable_datetime'];
    }
    public function session(): BelongsTo
    {
        return $this->belongsTo(LiveSession::class, 'live_session_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
