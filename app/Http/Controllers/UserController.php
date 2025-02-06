<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function storeAvatar(Request $request) {
        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);

        $user = Auth::user();
        $filename = $user->id . '-' . uniqid() . '.jpg';

        // Resize and save the image
        $img = Image::make($request->file('avatar'))->fit(120)->encode('jpg');

        // Store the image in the 'public/avatars' folder
        Storage::disk('public')->put('avatars/' . $filename, $img);

        return 'File successfully uploaded.';
    }

    public function showAvatarForm() {
        return view('avatar-form');
    }


    public function logout() {
        Auth::logout(); // log the user out
        return redirect('/')->with(['success' => 'You are now logged out!']);
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required',
        ]);

        // Check if user exists
        if(Auth::attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            // Store cookies
            $request->session()->regenerate();

            // Redirect back to homepage
            return redirect('/')->with(['success' => 'You are now logged in!']);
        } else {
            return redirect('/')->with(['failure' => 'Invalid credentials']);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if(Auth::check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        //
        $incomingFields = $request->validate([
           'username' => ['required', 'min:3', 'max:15', Rule::unique('users', 'username')], // 'Rule' is used to make the value for that column unique
           'email' => ['required' , 'email', Rule::unique('users', 'email')],
           'password' => ['required', 'min:8', 'max:15', 'confirmed'],
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // Store
        $user = User::create($incomingFields);

        // Login the user automatically after creating the account
        Auth::login($user);
        return redirect('/')->with(['success', 'You are now registered!']);
    }

    /**
     * Display the specified resource.
     */
    public function showProfile(User $user)
    {
        return view('profile-posts', ['username' => $user->username, 'posts' => $user->posts()->latest()->get(), 'numOfPost' => $user->posts()->count()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
