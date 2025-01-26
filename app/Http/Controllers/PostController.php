<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostController extends Controller
{
    use AuthorizesRequests;

    public function showEditForm(Post $post) {
        return view('edit-post', ['post' => $post]);
    }

    public function viewSinglePost(Post $post) {
        return view('single-post', ['post' => $post]);
    }

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
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCreatedPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        // Strip out html attributes
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = Auth::id();

        // Save to database
        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'Post successfuly created');
    }

    /**
     * Display the specified resource.
     */
    public function showCreatePost(Post $post)
    {
        //
        return view('create-post');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        // Strip out html attributes
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return back()->with('success', 'Post successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // $this->authorize('delete', $post); // Check if the user logged in is allowed to delete post
        $post->delete();
        return redirect('/profile/' . Auth::user()->username)->with('success', 'Post successfully deleted.');
    }
}
