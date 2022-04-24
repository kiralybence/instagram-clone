<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = [
        'created_at_ago',
        'is_liked',
        'like_count',
        'is_reply',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likedByUsers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likeable');
    }

    public function getCreatedAtAgoAttribute(): string
    {
        return $this->created_at->shortAbsoluteDiffForHumans();
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

    public function getIsReplyAttribute(): bool
    {
        return !empty($this->parent_id);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
