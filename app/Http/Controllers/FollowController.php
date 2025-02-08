<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createFollow(User $user)
    {
        // cannot follow yourself
        if($user->id == Auth::user()->id) {
            return back()->with('failure', 'You cannot follow yourself');
        }

        // cannot follow others more than once
        $alrFollowed = Follow::where([['user_id', '=', Auth::user()->id], ['followeduser', '=', $user->id]])->count();

        if($alrFollowed) {
            return back()->with('failure', 'You are already following this user');
        }

        $newFollow = new Follow;
        $newFollow->user_id = Auth::user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'User successfully followed');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removeFollow(User $user)
    {
        //
        Follow::where([['user_id', '=', Auth::user()->id],['followeduser', '=', $user->id]])->delete();
        return back()->with('success', 'User successfully unfollowed.');
    }
}
