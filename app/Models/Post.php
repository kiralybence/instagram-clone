<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Likeable;

    protected $appends = [
        'created_at_ago',
        'created_at_ago_short',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getCreatedAtAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getCreatedAtAgoShortAttribute(): string
    {
        return $this->created_at->shortAbsoluteDiffForHumans();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
