<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pseudo',
        'name',
        'firstname',
        'lastname',
        'email',
        'password',
        'slug',
        'is_admin',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

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
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->withPivot('accepted')
            ->withTimestamps();
    }

    public function friendsOf()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(Invitation::class, 'receiver_id');
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(Invitation::class, 'sender_id');
    }

    /**
     * Get all accepted friends (as a collection of User models).
     */
    public function acceptedFriends()
    {
        // Use a single query with a union-like logic or just merge the results
        // This is still better than the previous one because we can optimize the query
        $friends = $this->friends()->wherePivot('status', 'accepted')->get();
        $friendsOf = $this->friendsOf()->wherePivot('status', 'accepted')->get();
        return $friends->merge($friendsOf);
    }

    /**
     * Get all accepted friend IDs efficiently.
     */
    public function getAcceptedFriendIds()
    {
        return Cache::remember("user_{$this->id}_friend_ids", 3600, function () {
            $friends = $this->friends()->wherePivot('status', 'accepted')->pluck('friend_id');
            $friendsOf = $this->friendsOf()->wherePivot('status', 'accepted')->pluck('user_id');
            return $friends->concat($friendsOf)->unique()->toArray();
        });
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // Relationship removed
    // public function invitations()
    // {
    //     return $this->hasMany(Invitations::class);
    // }

<<<<<<< HEAD
    
=======
    ##genere code QR
    // protected static function booted()
    // {
    //     static::creating(function ($user){
    //         $user->qr_token = Str::uuid();
    //     });
    // } 
    ##


>>>>>>> 9cf12b4 (feat: add functionality of the code QR)

}
