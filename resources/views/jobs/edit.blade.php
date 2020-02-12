@extends('layouts.basic')


{{-- Content --}}
@section('content')

<h1 class="text-center font-bold text-black mt-150">Edit</h1>
<div class="container mt-50">
    @if($job->pic)
     <img class="img-cover" src="http://{{ Storage::url($job->pic) }}" alt="{{ $job->title }}">
    @endif
    <form action="{{ route('job.update', $job->id) }}" method="POST" class="create-job-form"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" value="{{ old('title') ?? $job->title }}">
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" value="{{ old('address') ?? $job->address }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') ?? $job->phone }}">
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="work_address">Work Address:</label>
                    <input type="text" name="work_address" id="work_address"
                        value="{{ old('work_address') ?? $job->work_address }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="salary">Salary:</label>
                    <input type="text" name="salary" id="salary" value="{{ old('salary') ?? $job->salary }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" value="{{ old('email') ?? $job->email }}">
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="description">Brief description:</label>
                    <textarea name="description" id="description" cols="30"
                        rows="3">{{ old('description') ?? $job->description }}</textarea>
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="details">More details:</label>
                    <textarea name="details" id="details" cols="30"
                        rows="10">{{ old('details') ?? $job->details }}</textarea>
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="tags">Tags you interested in: <small>Maximum 3 tags</small></label>
                    <div class="tags-container">
                        @foreach(old('tags') ?? $job->tags as $tag)
                        <span class="tag-input" style="position: relative;">
                            <span>{{ $tag }}</span>
                            <input type="hidden" value="{{ $tag }}" name="tags[]">
                            <span class="times" style="position: absolute;">
                                <i class="fas fa-times"></i>
                            </span>
                        </span>
                        @endforeach
                        <textarea id="tags" class="tags-box" cols="30" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <input type="file" name="pic" id="pic">
                    <label for="pic">Add a cover</label>
                </div>
            </div>
            @if($job->pic)
            <div class="col-12">
                <div class="form-group">
                    <input type="checkbox" name="delete_pic" id="delete_pic" @if(old('delete_pic')) checked @endif>
                    <label for="delete_pic">Delete the cover</label>
                </div>
            </div>
            @endif
        </div>
        <!-- /Row -->
        <div class="form-group">
            <button type="submit" class="btn btn-dark text-white d-block ml-auto">Submit</button>
        </div>
    </form>
</div>


@endsection
{{-- /Content --}}


{{-- Script --}}
@section('script')
<script>
    tagsBox.init({
            selector: ".tags-box",
            maxInputs: 3,
            tagClass: 'tag-input',
            close: '<i class="fas fa-times"></i>'
        });
</script>
@endsection
{{-- /Script --}}