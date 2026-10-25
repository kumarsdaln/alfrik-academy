<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

trait ResolvesPublicImages
{
    protected function coverImage(): Attribute
    {
        return Attribute::get(fn (?string $value) => $this->publicImageUrl($value));
    }

    protected function avatarPath(): Attribute
    {
        return Attribute::get(fn (?string $value) => $this->publicImageUrl($value));
    }

    private function publicImageUrl(?string $value): ?string
    {
        if (blank($value) || str_starts_with($value, '/') || str_starts_with($value, 'https://') || str_starts_with($value, 'http://')) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }
}
