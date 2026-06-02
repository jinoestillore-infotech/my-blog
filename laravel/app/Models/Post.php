<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'status',
        'tags',
        'views',
    ];

    /**
     * Get the user/author that owns this blog post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    
    /**
     * Get all users who have liked this blog post.
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes');
    }

    /**
     * Relationship: Unique user views tracking.
     */
    public function viewsRelation()
    {
        return $this->belongsToMany(User::class, 'post_views')->withTimestamps();
    }

    
    /**
     * Helper to verify if a user has already liked this post.
     */
    public function isLikedBy($user)
    {
        if (!$user) {
            return false;
        }
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Relationship: Get all users who have saved/bookmarked this post to read later.
     */
    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    /**
     * Helper to verify if a user has saved this post to read later.
     */
    public function isBookmarkedBy($user)
    {
        if (!$user) {
            return false;
        }
        return $this->bookmarkedBy()->where('user_id', $user->id)->exists();
    }

}