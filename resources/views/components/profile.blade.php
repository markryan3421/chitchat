<x-layout>
    <div class="container py-md-5 container--narrow">
      <h2>
        <img class="avatar-small" src="{{$sharedData['avatar']}}" /> {{$sharedData['username']}}
        @auth
        <!-- Follow Button -->
        @if (!$sharedData['followed'] AND Auth::user()->username != $sharedData['username'])
            <form class="ml-2 d-inline" action="/create-follow/{{$sharedData['username']}}" method="POST">
                @csrf
                <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
            </form>
        @endif

        <!-- Unfollow Button -->
        @if ($sharedData['followed'])
            <form class="ml-2 d-inline" action="/remove-follow/{{$sharedData['username']}}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm">Unfollow <i class="fas fa-user-times"></i></button>
            </form>
        @endif
            @if (Auth::user()->username == $sharedData['username'])
                <a class="btn btn-secondary btn-sm" href="/manage-avatar">Manage Avatar</a>
            @endif
        @endauth

      </h2>

      <div class="profile-nav nav nav-tabs pt-2 mb-4">
        <a href="/profile/{{$sharedData['username']}}" class="profile-nav-link nav-item nav-link {{Request::segment(3) == '' ? 'active' : ''}}">Posts: {{$sharedData['numOfPost']}}</a>
        <a href="/profile/{{$sharedData['username']}}/followers" class="profile-nav-link nav-item nav-link {{Request::segment(3) == 'followers' ? 'active' : ''}}">Followers: {{$sharedData['numOfFollowers']}}</a>
        <a href="/profile/{{$sharedData['username']}}/following" class="profile-nav-link nav-item nav-link {{Request::segment(3) == 'following' ? 'active' : ''}}">Following: {{$sharedData['numOfFollowings']}}</a>
      </div>

      <div class="profile-slot-content">
        {{$slot}}
      </div>
    </div>
</x-layout>
