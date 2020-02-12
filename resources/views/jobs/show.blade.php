@extends('layouts.basic')

@section('title')
{{ $job->title }}
@endsection

{{-- Content --}}
@section('content')

<div class="container-fluid mt-150 mb-100">
    <div class="row">
        <!-- Content -->
        <div class="col-md-8">
            <h2 class="text-dark text-center font-bold mb-100">{{ $job->title }}</h2>
            <!-- Image -->
            @if($job->pic)
            <img src="http://{{ Storage::url($job->pic) }}" class="img-cover" alt="{{ $job->title }}" />
            @else

            @endif
            <!-- Brief details -->
            @if($job->description)
            <h2 class="text-black font-weight-bold mb-15">Description:</h2>
            <p class="para">{{ $job->description }}</p>
            @endif
            <!-- Brief details -->
            <h2 class="text-black font-weight-bold mt-50 mb-30">Details</h2>
            <pre class="para">{{ $job->details }}</pre>
        </div>
        <!-- /Content -->

        <!-- Information -->
        <div class="col-md-4">
            <div class="contact-card text-dark ml-20" style="min-width: 300px;">
                <h2 class="font-bold text-center mb-30">Contact info</h2>
                <!-- ============ -->
                @if($job->address)
                <p class="sub-title">Address:</p>
                <p class="content-heading">{{ $job->address }}</p>
                @endif
                <!-- ============ -->
                <!-- ============ -->
                @if($job->salary)
                <p class="sub-title">Salary:</p>
                <p class="content-heading">{{ $job->salary }}</p>
                @endif
                <!-- ============ -->
                <!-- ============ -->
                @if($job->phone)
                <p class="sub-title">Phone:</p>
                <p class="content-heading">{{ $job->phone }}</p>
                @endif
                <!-- ============ -->
                <!-- ============ -->

                @if($job->email)
                <p class="sub-title">Email:</p>
                <p class="content-heading">{{ $job->email }}</p>
                @endif
                <!-- ============ -->
                <!-- ============ -->
                @if($job->work_address)
                <p class="sub-title">Work address:</p>
                <p class="content-heading">{{ $job->work_address }}</p>
                @endif
                <!-- ============ -->
                @if(Auth::check())
                @if($job->user_id != Auth::user()->id)
                @if($job->users->contains(Auth::user()->id))
                <form action="{{ route('user.unapply', $job->id) }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-block btn-red text-white">Unapply</button>
                </form>
                @else
                <form action="{{ route('user.apply', $job->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-block btn-green text-white">Apply</button>
                </form>
                @endif
                @elseif($job->user_id == Auth::user()->id)
                <form action="{{ route('job.delete', $job->id) }}" method="POST">
                    @csrf 
                    @method("DELETE")
                    <button class="btn btn-red text-white btn-block mb-10">Delete</button>
                </form>
                <a href="{{ route('job.edit', $job->slug) }}" class="btn btn-blue text-white btn-block">Edit</a>
                @endif
                @endif
            </div>
            <!-- ===================== -->
            <!-- ===================== -->
            <div class="tags d-block mb-30">
                @foreach($job->tags as $tag)
                <a href="http://findjob.test/search?search={{ $tag }}&type=job" class="tag mb-2">{{ $tag }}</a>
                @endforeach
            </div>
            <!-- ===================== -->
        </div>
        <!-- /Information -->
    </div>

    {{-- Applied User --}}
    @if(Auth::check() && $job->user_id == Auth::user()->id)


    <!-- Table -->
    <div class="table-wrapper mt-30">
        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Age</td>
                    <td>Resume</td>
                </tr>
            </thead>
            <tbody>
                @foreach($job->users as $user)
                <!-- Row -->
                <tr>
                    <td><a href="{{ route('user.profile', $user->slug) }}">{{ $user->first . ' ' . $user->second }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->birth_date->age }}</td>
                    @if($user->resume)
                    <td><a href="http://{{ Storage::url($user->resume) }}" downlaod
                            class="btn btn-green text-white font-bold">Download Resume</a></td>
                    @else
                    <td>This user has no resume</td>
                    @endif
                    <!-- /Row -->
                    @endforeach
            </tbody>
        </table>
    </div>


    @endif
</div>


@endsection
{{-- /Content --}}


{{-- Script --}}
@section('script')


@endsection
{{-- /Script --}}