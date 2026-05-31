<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'avatar',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        /**
     * Get all the blog posts written by this user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all posts that this user has liked.
     */
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_likes');
    }
    
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'user_id')->withTimestamps();
    }

    /**
     * Users that follow THIS user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower_id')->withTimestamps();
    }

    /**
     * Helper to quickly check if this user is already following another user.
     */
    public function isFollowing($userId)
    {
        return $this->following()->where('user_id', $userId)->exists();
    }

    /**
     * Get the writer's dynamic rank title based on their follower count.
     * Incorporates 6 distinct developmental tiers.
     *
     * @return string
     */
    public function getRankTitleAttribute()
    {
        // Use loaded follower count or execute a fallback count
        $count = $this->followers_count ?? $this->followers()->count();

        if ($count >= 200) {
            return 'Legendary Creator';
        } elseif ($count >= 100) {
            return 'Literary Pro';
        } elseif ($count >= 50) {
            return 'Elite Writer';
        } elseif ($count >= 10) {
            return 'Storyteller';
        } elseif ($count >= 5) {
            return 'Rising Voice';
        } else {
            return 'Novice Scribe';
        }
    }

    /**
     * Get the corresponding premium badge styling class matching the rank.
     *
     * @return string
     */
    public function getRankBadgeClassAttribute()
    {
        $count = $this->followers_count ?? $this->followers()->count();

        if ($count >= 200) {
            return 'bg-warning-subtle text-warning-emphasis';
        } elseif ($count >= 100) {
            return 'bg-danger-subtle text-danger';
        } elseif ($count >= 50) {
            return 'bg-success-subtle text-success';
        } elseif ($count >= 10) {
            return 'bg-primary-subtle text-primary';
        } elseif ($count >= 5) {
            return 'bg-info-subtle text-info';
        } else {
            return 'bg-light-subtle text-secondary';
        }
    }
}
