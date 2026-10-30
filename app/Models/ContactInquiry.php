<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'email',
    'topic',
    'message',
    'status',
    'handled_at',
])]
class ContactInquiry extends Model
{
    protected function casts(): array
    {
        return [
            'handled_at' => 'immutable_datetime',
        ];
    }

    /**
     * Determine whether the inquiry has been handled.
     */
    public function isHandled(): bool
    {
        return $this->status === 'handled';
    }
}