<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = [
        'created_at_ago',
        'is_liked',
        'like_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function likedByUsers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likeable');
    }

    public function getCreatedAtAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsLikedAttribute(): bool
    {
        return $this->likedByUsers()
            ->where('id', auth()->id())
            ->exists();
    }

    public function getLikeCountAttribute(): int
    {
        return $this->likedByUsers()->count();
    }
}
