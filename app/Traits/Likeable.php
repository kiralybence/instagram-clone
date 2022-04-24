<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @mixin Model
 */
trait Likeable
{
    protected function initializeLikeable()
    {
        $this->append([
            'is_liked',
            'like_count',
        ]);
    }

    public function likedByUsers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likeable');
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
