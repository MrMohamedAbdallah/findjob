@extends('layouts.basic')

@section('messages')
Nothing to show
@endsection

{{-- Register Error --}}
@php
$registerError = false;
foreach(["fname", "lname", "remail", "birth_date", "rpassword", "rpassword_confirmation"] as $errorName){
    if($errors->has($errorName)){
        $registerError = true;
        break;
    }
}

@endphp

{{-- Content --}}
@section('content')
<!-- Header -->
<header class="header header-1" style="min-height: 1200px;margin-top: 30px;">
    <div class="overlay"></div>
    <div class="container-fluid">
        <div class="header-content">
            <div class="row">
                <div class="col-md-6 col-lg-7">
                    <h1 class="text text-white">
                        Your <span class="text-green">next job</span> is here
                    </h1>
                    <h1 class="text text-white">
                        Drop your <span class="text-green">Resume</span> &
                        <span class="text-green">Get</span> your desired job
                    </h1>
                </div>
                <div class="col-md-6 col-lg-5">
                    <!-- Form card -->
                    <div class="form-card">
                        <ul class="tabs">
                            <li class="tab login @if($registerError) inactive @endif" data-show="#login-form" data- id="login-btn">
                                Login
                            </li>
                            <li class="tab register @if(!$registerError) inactive @endif" data-show="#register-form" id="register-btn">
                                Register
                            </li>
                        </ul>
                        <div class="content">
                            <!-- Login -->
                            <div class="login @if($registerError) d-none @endif" id="login-form">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <!-- Email -->
                                    <div class="form-group mb-30">
                                        <label for="email" class="d-block">Email:</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            class="@error('email') is-invalid border-danger @enderror" />
                                        @error('email')
                                        <small class="invalid-feedback" style="display: block;">Invalid email or password</small>
                                        @enderror
                                    </div>
                                    <!-- Password -->
                                    <div class="form-group mb-30">
                                        <label for="password" class="d-block">Password:</label>
                                        <input type="password" name="password" id="password"
                                            class="@error('password') is-invalid border-danger @enderror" />
                                            @error('password')
                                            <small class="invalid-feedback" style="display: block;">The password is invalid</small>
                                            @enderror
                                    </div>
                                    <!-- Password -->
                                    <div class="form-group mb-10">
                                        <input type="checkbox" name="remember" id="remember" />
                                        <label for="remember">Remember me</label>
                                    </div>

                                    {{-- Reset --}}
                                    @if (Route::has('password.request'))
                                    <p class="p-0 text-blue text-center">
                                        <a href="{{ route('password.request') }}"><small>Forget your
                                                password?</small></a>
                                    </p>
                                    @endif
                                    {{-- /Reset --}}

                                    <!-- Submit -->
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-green text-white btn-block mb-10">
                                            Login
                                        </button>
                                        <p class="p-0 text-blue text-center"><small>It's free</small></p>
                                    </div>
                                </form>
                            </div>
                            <!-- /Login -->
                            <!-- Register -->
                            <div class="register @if(!$registerError) d-none @endif" id="register-form">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <!-- Name -->
                                    <div class="row">
                                        {{-- First --}}
                                        <div class="col-md-6">
                                            <div class="form-group mb-30">
                                                <label for="fname" class="d-block">First Name:</label>
                                                <input type="text" name="fname" id="fname" value="{{ old('fname') }}"
                                                    class="@error('fname') is-invalid border-danger @enderror" />
                                                    @error('fname')
                                                    <div class="invalid-feedback" style="display: block;">Invalid name</div>
                                                    @enderror
                                            </div>
                                        </div>

                                        {{-- Last --}}
                                        <div class="col-md-6">
                                            <div class="form-group mb-30">
                                                <label for="lname" class="d-block">Last Name:</label>
                                                <input type="text" name="lname" id="lname" value="{{ old('lname') }}"
                                                    class="@error('lname') is-invalid border-danger @enderror" />
                                                    @error('lname')
                                                    <div class="invalid-feedback" style="display: block;">Invalid name</div>
                                                    @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Email -->
                                    <div class="form-group mb-30">
                                        <label for="remail" class="d-block">Email:</label>
                                        <input type="email" name="remail" id="remail" value="{{ old('remail') }}"
                                            class="@error('remail') is-invalid border-danger @enderror" />
                                            @error('remail')
                                            <div class="invalid-feedback" style="display: block;">Email is invalid or used</div>
                                            @enderror
                                    </div>
                                    <!-- Birthdate -->
                                    <div class="form-group mb-30">
                                        <label for="birth_date" class="d-block">Birth Date:</label>
                                        <input type="date" name="birth_date" id="birth_date"
                                            class="@error('birth_date') is-invalid border-danger @enderror" />
                                            @error('birth_date')
                                            <div class="invalid-feedback" style="display: block;">You have to be older than 13 years old</div>
                                            @enderror
                                    </div>
                                    <!-- Password -->
                                    <div class="form-group mb-30">
                                        <label for="rpassword" class="d-block">Password:</label>
                                        <input type="password" name="rpassword" id="rpassword"
                                            class="@error('rpassword') is-invalid border-danger @enderror" />
                                            @error('rpassword')
                                            <div class="invalid-feedback" style="display: block;">Invalid password</div>
                                            @enderror
                                    </div>
                                    <!-- confirm password -->
                                    <div class="form-group mb-30">
                                        <label for="rpassword_confirmation" class="d-block">Confirm Password:</label>
                                        <input type="password" name="rpassword_confirmation" id="rpassword_confirmation"
                                            class="@error('rpassword_confirmation') is-invalid border-danger @enderror" />
                                        @error('rpassword_confirmation')
                                        <div class="invalid-feedback" style="display: block;">Passwords don't match</div>
                                        @enderror
                                    </div>
                                    <!-- Submit -->
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-green text-white btn-block mb-10">
                                            Register
                                        </button>
                                        <p class="p-0 text-blue text-center"><small>It's free</small></p>
                                    </div>
                                </form>
                            </div>
                            <!-- /Register -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- /Header -->

<!-- How Section -->
<section class="how mt-50 mb-150">
    <h1 class="text-center text-dark mb-100 font-bold">How it works</h1>
    <div class="container-fluid">
        <!-- First row -->
        <div class="row">
            <!-- SVG -->
            <div class="col-md-6 d-flex flex-center">
                <img src="images/card 1.svg" class="w-100 svg-sm" alt="for companies" />
            </div>
            <!-- /SVG -->
            <div class="col-md-6">
                <h2 class="text-dark font-weight-bold mt-30">Individulas</h2>
                <p class="my-50">
                    You can search for jobs and apply to it, The company will be able
                    to see your resume and you contact info.
                </p>
                <p class="my-50">
                    By uploading your resume ,putting you contact info and sharing
                    your skills and interests, Companies will be able to search and
                    contact you more easily.
                </p>
                <!-- Get started -->
                <div class="d-flex flex-center-x">
                    <button class="btn btn-green text-white mr-15 px-20 py-10" onclick="window.scroll(0, 0);">
                        Get Started
                    </button>
                    <small class="text-blue">It's free</small>
                </div>
            </div>
        </div>
        <!-- /First row -->
        <!-- Second row -->
        <div class="row row-reverse-md mt-150">
            <div class="col-md-6">
                <h2 class="text-dark font-weight-bold mt-30">Companies</h2>
                <p class="my-50">
                    You can post your job requirements and let people apply to it, It
                    gives you the freedom to choose from wide range of people.
                </p>
                <p class="my-50">
                    You can search for people that have the skills you need for the
                    jobs, reviewing their resume and get the contact info to contact
                    with them.
                </p>
                <!-- Get started -->
                <div class="d-flex flex-center-x">
                    <button class="btn btn-green text-white mr-15 px-20 py-10" onclick="window.scroll(0, 0);">
                        Get Started
                    </button>
                    <small class="text-blue">It's free</small>
                </div>
            </div>

            <!-- SVG -->
            <div class="col-md-6 d-flex flex-center">
                <img src="images/card 2.svg" class="w-100 svg-sm" alt="for companies" />
            </div>
            <!-- /SVG -->
        </div>
        <!-- /Second row -->
    </div>
</section>

<section class="map pb-40">
    <div class="overlay"></div>
    <div class="container-fluid">
        <!-- Carousel -->
        <div class="carousel-wrapper">
            <div class="slides-wrapper">
                <!-- Slide -->
                <div class="slide">
                    <div class="quote">
                        <h2 class="mb-10">
                            Findjop helped us to find the most skilled and responsible
                            employees with zero money spent, It was never been easier like
                            that.
                        </h2>
                        <h2 class="font-bold text-dark name mb-10">Jane Doe</h2>
                        <small class="position">CEO of wellknown company</small>
                    </div>
                </div>
                <!-- /Slide -->
                <!-- Slide -->
                <div class="slide">
                    <div class="quote">
                        <h2 class="mb-10">
                            Findjop helped us to find the most skilled and responsible
                            employees with zero money spent, It was never been easier like
                            that.
                        </h2>
                        <h2 class="font-bold text-dark name mb-10">Jane Doe</h2>
                        <small class="position">CEO of wellknown company</small>
                    </div>
                </div>
                <!-- /Slide -->
                <!-- Slide -->
                <div class="slide">
                    <div class="quote">
                        <h2 class="mb-10">
                            Findjop helped us to find the most skilled and responsible
                            employees with zero money spent, It was never been easier like
                            that.
                        </h2>
                        <h2 class="font-bold text-dark name mb-10">Jane Doe</h2>
                        <small class="position">CEO of wellknown company</small>
                    </div>
                </div>
                <!-- /Slide -->
            </div>

            <ul class="carousel-bullets">
                <li class="active"></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <!--/Carousel -->

        <!-- Ready card -->
        <div class="ready">
            <h1 class="font-bold text-black">Ready to find your job?</h1>
            <!-- Get started -->
            <div class="d-flex flex-center-x">
                <button class="btn btn-green text-white mr-15 px-20 py-10" onclick="window.scroll(0, 0);">
                    Get Started
                </button>
                <small class="text-blue">It's free</small>
            </div>
        </div>
    </div>
</section>
@endsection
{{-- /Content --}}




{{-- Script --}}
@section('script')
<script>
    // =============== Carousel ===============
        // Slides wrapper
        let slidesWrapper = document.querySelector('.slides-wrapper');
        // Get all slides
        let slides = document.querySelectorAll('.slide');
        // Get all bullets
        let bullets = document.querySelectorAll('.carousel-bullets li');
        // The current position
        let currentPosition = 0;
        // Last position
        let lastPosition = 0;

        // Change the when cliking the bullet
        bullets.forEach((b, index)=> {
            b.addEventListener('click', ()=>{
                sliding(index);
            })
        });

        // Sliding
        function sliding(index){
            slidesWrapper.style.transform = 'translate(-' + (index * 100) + '%)';
            bullets[lastPosition].classList.remove('active');
            bullets[index].classList.add('active');  

            // Update positions
            currentPosition = index;
            lastPosition = index;
        }
        // Move it automatically
        function slideIt(){

            let interval = setInterval(()=>{
                sliding((currentPosition+1) % slides.length);
            }, 20000);

        }
        slideIt();
</script>
@endsection
{{-- /Script --}}