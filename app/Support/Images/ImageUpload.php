<?php

namespace App\Support\Images;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUpload
{
    public static function store(Request $request, string $field, string $directory, int $width, int $height): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $path = $request->image($field)
            ->orient()
            ->cover($width, $height)
            ->toWebp()
            ->quality(82)
            ->storePublicly($directory, 'public');

        return $path ?: null;
    }

    public static function deleteManaged(?string $path, string $directory): void
    {
        if ($path && str_starts_with($path, $directory.'/')) {
            Storage::disk('public')->delete($path);
        }
    }
}