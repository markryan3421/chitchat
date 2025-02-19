<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'avatar',
        'email',
        'password',
    ];

    public function getAvatarAttribute() {
        return $this->attributes['avatar']
            // If 'avatar' column is not null, display that avatar
            ? asset('storage/avatars/' . $this->attributes['avatar'])

            // Else, display the default avatar
            : asset('/default-avatar.jpg');
    }

    public function feedPosts() {
        return $this->hasManyThrough(Post::class, Follow::class, 'user_id', 'user_id', 'id', 'followeduser'); //1st - what table to access, 2nd - the table with reference relationship to first argument(intermediate table), 3rd - FK of intermediate table, 4th - FK of first argument, 5th - PK of this model(user), 6th - PK of intermediate table
    }


    public function followers() {
        return $this->hasMany(Follow::class, 'followeduser'); // 'followeduser' is the foreign key or id of the 'users' table from the 'follow' table
    }

    public function followings() {
        return $this->hasMany(Follow::class, 'user_id'); // 'user' is the id of the user being followed, (id sang gin-follow mo)
    }

    public function posts() {
        return $this->hasMany(Post::class);
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


}
