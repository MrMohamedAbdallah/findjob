@extends('layouts.basic')

@section('messages')
Nothing to show here
@endsection

{{-- Content --}}
@section('content')

<h1 class="text-center font-bold text-black mt-150">Create A Job</h1>
<div class="container mt-50">
    <form action="{{ route('job.create') }}" method="POST" class="create-job-form" enctype="multipart/form-data">
        @csrf
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="@error('title') is-invalid border-danger @enderror">
                    @error('title')
                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                        class="@error('address') is-invalid border-danger @enderror">
                    @error('address')
                    <div class="invalid-feedback">Invalid address</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="@error('phone') is-invalid border-danger @enderror">
                    @error('phone')
                    <div class="invalid-feedback">Invalid phone</div>
                    @enderror
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="work_address">Work Address:</label>
                    <input type="text" name="work_address" id="work_address" value="{{ old('work_address') }}"
                        class="@error('work_address') is-invalid border-danger @enderror">
                    @error('work_address')
                    <div class="invalid-feedback">Invalid address</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="salary">Salary:</label>
                    <input type="text" name="salary" id="salary" value="{{ old('salary') }}"
                        class="@error('salary') is-invalid border-danger @enderror">
                    @error('salary')
                    <div class="invalid-feedback">Invalid salary</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                        class="@error('email') is-invalid border-danger @enderror">
                    @error('email')
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="description">Brief description:</label>
                    <textarea name="description" id="description" cols="30" rows="3"
                        class="@error('description') is-invalid border-danger @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="details">More details:</label>
                    <textarea name="details" id="details" cols="30" rows="10"
                        class="@error('details') is-invalid border-danger @enderror">{{ old('details') }}</textarea>
                    @error('details')
                    <div class="invalid-feedback">{{ $errors->first('details') }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="tags">Tags you interested in: <small>Maximum 3 tags</small></label>
                    <div class="tags-container @error('first') is-invalid border-danger @enderror">
                        @foreach(old('tags') ?? [] as $tag)
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
                    @error('tags')
                    <div class="invalid-feedback">{{ $errors->first('tags') }}</div>
                    @enderror
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
        </div>
        <!-- /Row -->
        <div class="form-group">
            <button type="submit" class="btn btn-dark text-white d-block ml-auto">Submit</button>
        </div>
    </form>
</div>
@endsection


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