<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function friendsOf()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function receivedFriendRequests()
    {
        return $this->friendsOf()->wherePivot('status', 'pending');
    }

    public function sentFriendRequests()
    {
        return $this->friends()->wherePivot('status', 'pending');
    }

    public function acceptedFriends()
    {
        
        $friends = $this->friends()->wherePivot('status', 'accepted')->get();
        $friendsOf = $this->friendsOf()->wherePivot('status', 'accepted')->get();
        return $friends->merge($friendsOf);
    }
    
}
