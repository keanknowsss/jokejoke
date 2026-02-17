<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        'first_name',
        'last_name',
        'email',
        'username',
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

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getProfilePicAttribute()
    {
        return $this->profile?->profile_pic_path ?
            Storage::url($this->profile->profile_pic_path) :
            asset('assets/placeholders/user_avatar.png');
    }

    public function getCoverPicAttribute()
    {
        return $this->profile?->cover_pic_path ?
            Storage::url($this->profile->cover_pic_path) :
            asset('assets/placeholders/user_cover.jpg');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function follow(User $userFollowing)
    {
        DB::transaction(function () use ($userFollowing) {
            $this->followers()->create([
                'follower_id' => $userFollowing->id
            ]);

            if ($this->summary()->exists()) {
                $this->summary()->increment('following_count');
            } else {
                $this->summary()->create([
                    'following_count' => 1
                ]);
            }

            if ($userFollowing->summary()->exists()) {
                $userFollowing->summary()->increment('follower_count');
            } else {
                $userFollowing->summary()->create([
                    'follower_count' => 1
                ]);
            }
        });
    }

    public function followers()
    {
        return $this->hasMany(Follower::class);
    }

    public function summary()
    {
        return $this->hasOne(UserSummary::class);
    }
}
