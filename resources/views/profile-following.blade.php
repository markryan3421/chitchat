<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s following/s">
    <div class="list-group">
        @foreach ($followings as $following)
            <a href="/post/{{$following->userBeingFollowed->username}}" class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{$following->userBeingFollowed->avatar}}" />
                {{ $following->userBeingFollowed->username }}
            </a>
        @endforeach
    </div>
</x-profile>
