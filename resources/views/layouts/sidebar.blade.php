<nav class="right-nav open" id="right-nav">
    <ul class="right-nav-list">
        <li>
            @if(Auth::user()->hasRole('root'))
            <a href="{{ route('root.jobs') }}" class="@if(request()->is('root/jobs')) active @endif">Jobs</a>
            @else
            <a href="{{ route('admin.jobs') }}" class="@if(request()->is('admin/jobs')) active @endif">Jobs</a>
            @endif
        </li>
        <li>
            @if(Auth::user()->hasRole('root'))
            <a href="{{ route('root.users') }}" class="@if(request()->is('root/users')) active @endif">Users</a>
            @else
            <a href="{{ route('admin.users') }}" class="@if(request()->is('admin/users')) active @endif">Users</a>
            @endif
        </li>
    </ul>
</nav>

<!-- Hamburger menu icon -->
<ul class="menu-icon" id="menu-icon">
    <li></li>
    <li></li>
    <li></li>
</ul>