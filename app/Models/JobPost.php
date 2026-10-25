<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    protected $fillable = ['posted_by', 'contact_name', 'contact_email', 'company_website', 'title', 'slug', 'company', 'location', 'workplace_type', 'employment_type', 'seniority', 'salary_range', 'summary', 'description', 'skills', 'application_url', 'expires_at', 'status', 'published_at'];

    protected $hidden = ['contact_name', 'contact_email', 'company_website'];

    protected function casts(): array
    {
        return ['skills' => 'array', 'expires_at' => 'datetime', 'published_at' => 'datetime'];
    }

    public function poster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
