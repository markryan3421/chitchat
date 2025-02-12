<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    // Mga nag-follow sa imo
    public function userDoingTheFollowing() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Mga gin-follow mo
    public function userBeingFollowed() {
        return $this->belongsTo(User::class, 'followeduser');
    }
}
