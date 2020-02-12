<!-- Navbar -->
<nav class="navbar px-0">
    <div class="container-fluid">
        <div class="nav-brand">
            <a href="/"><img src="{{ asset('images/logo.svg') }}" alt="findjob logo" class="logo" /></a>
        </div>
        <div class="navbar-icon ml-auto" id="navbar-icon">
            <ul>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>

        <div class="lists-container" id="lists">
            @auth
            @php
            $user = Auth::user();
            @endphp
            <ul class="navbar-list">
                <li class="navbar-item">
                    <a href="{{ route('profile') }}"
                        class="navbar-link @if(request()->is('profile')) active @endif">Profile</a>
                </li>
                @if($user->hasRole('root'))
                <li class="navbar-item">
                    <a href="{{ route('root') }}"
                        class="navbar-link @if(request()->is('root/*')) active @endif">Admin</a>
                </li>
                @elseif($user->hasRole('admin'))
                <li class="navbar-item">
                    <a href="{{ route('admin') }}"
                        class="navbar-link @if(request()->is('admin*')) active @endif">Admin</a>
                </li>
                @endif
                <li class="navbar-item">
                    <a href="{{ route('job.create') }}"
                        class="navbar-link @if(request()->is('job/create')) active @endif">Create a job</a>
                </li>
            </ul>
            {{-- If Not Authed --}}
            <!-- Log out -->
            <ul class="navbar-list list-2 ml-auto mr-0">
                <li class="navbar-item">
                    <i class="fas fa-user"></i>
                    <b class="font-bold text-blue">{{ $user->first . ' ' . $user->last }}</b>
                </li>
                <li class="navbar-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline m-0 p-0">
                        @csrf
                        <button type="submit" class="navbar-link btn p-0 m-0"><i
                                class="fas fa-sign-out-alt mr-10"></i>Log out</button>
                    </form>
                </li>
            </ul>
            @endif
        </div>
    </div>
    <div class="pro" id="progress">
        <div class="pro-bar" id="progress-bar"></div>
    </div>
</nav>
<!-- /Navbar -->