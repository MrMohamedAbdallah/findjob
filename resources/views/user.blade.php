<div class="col-xl-4 col-md-6">
    <div class="employee-card">
        @if($user->pic)
        <img src="http://{{ Storage::url($user->pic) }}" alt="%Person Name%" />
        @else
        <img src="/storage/images/default.jpg" alt="%Person Name%" />
        @endif
        <div class="card-content">
            <h1 class="card-heading">
                <a href="{{ route('user.profile', $user->slug) }}">{{ $user->first . ' ' . $user->last }}</a>
            </h1>

            <div class="user-info">
                <div class="work">{{ $user->works_as }}</div>
                <div class="level">{{ $user->level }}</div>
                <div class="old">{{ $user->birth_date->age }}</div>
            </div>

            <div class="tags">
                @foreach($user->tags as $tag)
                <a href="http://findjob.test/search?search={{ $tag }}&type=user" class="tag">{{ $tag }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>