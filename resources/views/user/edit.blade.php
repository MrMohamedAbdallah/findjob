@extends('layouts.basic')

@section('messages')
Nothing to show here
@endsection


@section('content')
<h1 class="text-center font-bold text-black mt-150">Edit Your Profile</h1>
<div class="container mt-50">
    <form action="{{ route('user.edit') }}" method="POST" class="edit-profile-form">
        @csrf
        @method("PUT")
        <!-- Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="first">First Name:</label>
                    <input type="text" name="first" id="first" value="{{ old('first') ?? $user->first }}"
                        class="@error('first') is-invalid border-danger @enderror" />
                        @error('first')
                        <div class="invalid-feedback">{{ $errors->first('first') }}</div>
                        @enderror 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="last">Last Name:</label>
                    <input type="text" name="last" id="last" value="{{ old('last') ?? $user->last }}"
                        class="@error('last') is-invalid border-danger @enderror" />
                        @error('last')
                        <div class="invalid-feedback">{{ $errors->first('last') }}</div>
                        @enderror 
                </div>
            </div>
        </div>

        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="works_as">Work: </label>
                    <input type="text" name="works_as" id="works_as" value="{{ old('works_as') ?? $user->works_as }}"
                        class="@error('works_as') is-invalid border-danger @enderror" />
                        @error('works_as')
                        <div class="invalid-feedback">{{ $errors->first('works_as') }}</div>
                        @enderror 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="level">Your skills level: </label>
                    <input type="text" name="level" id="level" value="{{ old('level') ?? $user->level }}"
                        class="@error('level') is-invalid border-danger @enderror" />
                        @error('level')
                        <div class="invalid-feedback">{{ $errors->first('level') }}</div>
                        @enderror 
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="email" value="{{ old('email') ?? $user->email }}"
                        class="@error('email') is-invalid border-danger @enderror" />
                        @error('email')
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @enderror 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone number: </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') ?? $user->phone }}"
                        class="@error('phone') is-invalid border-danger @enderror" />
                        @error('phone')
                        <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                        @enderror 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birth_date">Birth:</label>
                    <input type="date" name="birth_date" id="birth_date"
                        value="{{ old('birth_date') ?? $user->birth_date->format('Y-m-d') }}"
                        class="@error('birth_date') is-invalid border-danger @enderror" />
                        @error('birth_date')
                        <div class="invalid-feedback">{{ $errors->first('birth_date') }}</div>
                        @enderror 
                </div>
            </div>
        </div>
        <!-- /Row -->
        <div class="form-group">
            <label for="details" class="font-bold">Details about you:</label>
            <textarea name="details" id="details" cols="30" rows="10"
                class="@error('details') is-invalid border-danger @enderror">{{ old('details') ?? $user->details }}</textarea>
                @error('details')
                <div class="invalid-feedback">{{ $errors->first('details') }}</div>
                @enderror 
        </div>
        <div class="form-group">
            <label for="tags">Tags you interested in: <small>Miximum 10 tags</small></label>
            <!-- Tags box -->
            <div class="tags-container @error('first') is-invalid border-danger @enderror">
                {{-- Display tags --}}
                @foreach(old('tags') ?? $user->tags as $tag)
                <span class="tag-input" style="position: relative;">
                    <span>{{ $tag }}</span>
                    <input type="hidden" value="{{ $tag }}" name="tags[]">
                    <span class="times" style="position: absolute;">
                        <i class="fas fa-times"></i>
                    </span>
                </span>
                @endforeach
                {{-- /Tags --}}
                <textarea id="tags" class="tags-box" cols="30" rows="2"></textarea>
            </div>
            @error('tags')
            <div class="invalid-feedback">{{ $errors->first('tags') }}</div>
            @enderror 
        </div>
        <div class="form-group multi-buttons">
            <div>
                <input type="checkbox" name="active" id="active" @if(old('active') ?? $user->active) checked @endif>
                <label for="active" class="my-0">Active</label>
            </div>
            <button class="btn btn-dark text-white">Save changes</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    tagsBox.init({
                  selector: ".tags-box",
                  maxInputs: 10,
                  tagClass: 'tag-input',
                  close: '<i class="fas fa-times"></i>'
              });
</script>
@endsection