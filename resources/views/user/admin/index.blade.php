@extends('layouts.basic')

@section('content')
<div class="panel-container">
    <div class="container-fluid mt-100">
        <div class="row">
            <!-- Card -->
            <div class="col-lg-4 col-md-6">
                @if(Auth::user()->hasRole('root'))
                <a href="{{ route('root.jobs') }}" class="admin-card bg-green">
                    <h2 class="numbers text-center font-bold">{{ $jobsNumber }}</h2>
                    <h2 class="title text-center font-bold">Jobs</h2>
                </a>
                @else
                <a href="{{ route('admin.jobs') }}" class="admin-card bg-green">
                    <h2 class="numbers text-center font-bold">{{ $jobsNumber }}</h2>
                    <h2 class="title text-center font-bold">Jobs</h2>
                </a>
                @endif
            </div>
            <!-- /Card -->
            <!-- Card -->
            <div class="col-lg-4 col-md-6">
                @if(Auth::user()->hasRole('root'))
                <a href="{{ route('root.users') }}" class="admin-card bg-blue">
                    <h2 class="numbers text-center font-bold">{{ $usersNumber }}</h2>
                    <h2 class="title text-center font-bold">Users</h2>
                </a>
                @else
                <a href="{{ route('admin.users') }}" class="admin-card bg-blue">
                    <h2 class="numbers text-center font-bold">{{ $usersNumber }}</h2>
                    <h2 class="title text-center font-bold">Users</h2>
                </a>
                @endif
            </div>
            <!-- /Card -->
        </div>
    </div>
</div>

@component('layouts.sidebar')
@endcomponent


@endsection