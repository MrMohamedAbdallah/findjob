@extends('layouts.basic')



@section('content')


<div class="panel-container">
    <div class="container-fluid mt-100">
        <h1 class="text-center mb-10 font-bold">Jobs</h1>
        <p class="text-center mb-40"><b>Search for: </b><small>{{ $searchTerm }}</small></p>
        @component('user.admin.search', ['type' => 'job'])
        @endcomponent

        <!-- Table -->
        <div class="table-wrapper mt-30">
            <table>
                <thead>
                    <tr>
                        <td>#ID</td>
                        <td>Job Title</td>
                        <td>Email</td>
                        <td>Created at</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <!-- Row -->
                    <tr>
                        <td>{{ $job->id }}</td>
                        @if(strlen($job->title) > 50)
                        <td><a href="{{ route('job.show', $job->slug) }}">{{ substr($job->title,0, 50) . '...' }}</a>
                        </td>
                        @else
                        <td><a href="{{ route('job.show', $job->slug) }}">{{ $job->title }}</a></td>
                        @endif
                        <td>{{ $job->email }}</td>
                        <td>{{ $job->created_at->diffForHumans() }}</td>
                        <td class="d-flex">
                            @if(Auth::user()->hasRole('root'))
                            <form action="{{ route('root.job.delete', $job->id) }}" method="POST" class="d-inilne">
                                @else
                                <form action="{{ route('admin.job.delete', $job->id) }}" method="POST" class="d-inilne">
                                    @endif
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you wnat to delete thast job');"
                                        class="btn btn-danger text-white font-bold">
                                        Delete
                                    </button>
                                </form>
                        </td>
                    </tr>
                    <!-- /Row -->
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="my-10 text-center">{{ $jobs->links('pagination') }}</div>
    </div>
</div>



@component('layouts.sidebar')
@endcomponent
@endsection