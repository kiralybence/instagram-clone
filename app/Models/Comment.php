<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Likeable;

    protected $fillable = [
        'content',
        'parent_id',
        'post_id',
        'user_id',
    ];

    protected $appends = [
        'created_at_ago',
        'created_at_ago_short',
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

    public function getCreatedAtAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getCreatedAtAgoShortAttribute(): string
    {
        return $this->created_at->shortAbsoluteDiffForHumans();
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
        return $this->hasMany(Comment::class, 'parent_id')
            // This is the only way I could get recursive relationships to work with JSON
            ->with([
                'parent',
                'parent.user',
                'replies',
                'replies.user',
            ]);
    }
}
