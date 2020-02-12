@extends('layouts.basic')

@section('content')

<div class="container-fluid mt-150 mb-100">
    <div class="row">
        <!-- Profile Image -->
        <div class="col-md-4 mb-3">
            @if($user->pic)
            <img src="http://{{ Storage::url($user->pic) }}" id="user-pic" alt="{{ $user->first . ' ' . $user->last }}"
                class="profile-img mx-auto d-block" />
            @else
            <img src="/storage/images/default.jpg" id="user-pic" alt="{{ $user->first . ' ' . $user->last }}"
                class="profile-img mx-auto d-block" />
            @endif
            @if($user->id == Auth::user()->id)
            <div class="mb-30">
                <form action="{{ route('user.pic') }}" class="text-center" id="profile-pic-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <input type="file" name="pic" id="pic" class="d-none">
                    <label for="pic" class="btn btn-dark mx-auto d-inline-block">
                        Change your picture
                    </label>
                </form>
            </div>
            @endif
            <div class="multi-buttons">
                @if($user->id == Auth::user()->id)
                <form action="{{ route('user.resume') }}" class="text-center" id="resume-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <input type="file" name="resume" id="resume" class="d-none">
                    <label for="resume" class="btn btn-dark">Upload resume</label>
                </form>
                @endif
                @if($user->resume)
                <a href="http://{{ Storage::url($user->resume) }}" download target="_blank"
                    class="btn btn-green text-white" for="upload-resume" id="download-resume">
                    Download resume
                </a>
                @else
                <a href="#" download target="_blank" style="display:none" class="btn btn-green text-white"
                    for="upload-resume" id="download-resume">
                    Download resume
                </a>
                @endif
            </div>
        </div>
        <!-- Profile Image -->
        <div class="offset-md-1"></div>
        <div class="col-md-7">
            <div class="user-info">
                <!-- ===================== -->
                <div class="info-block">
                    <p class="title">My name is:</p>
                    <p class="value">{{ $user->first . ' ' . $user->last }}</p>
                </div>
                <!-- ===================== -->
                <!-- ===================== -->
                <div class="info-block">
                    <p class="title">Age:</p>
                    <p class="value">{{ $user->birth_date->age }}</p>
                </div>
                <!-- ===================== -->
                <!-- ===================== -->
                <div class="multi">
                    @if($user->works_as)
                    <div class="info-block">
                        <p class="title">Want to work as:</p>
                        <p class="value">Full-stack web-developer</p>
                    </div>
                    @endif

                    @if($user->level)
                    <div class="info-block">
                        <p class="title">Level:</p>
                        <p class="value">Junior</p>
                    </div>
                    @endif
                </div>
                <!-- ===================== -->
                <!-- ===================== -->
                <div class="info-block">
                    <p class="title">My email:</p>
                    <p class="value">{{ $user->email }}</p>
                </div>
                <!-- ===================== -->
                <!-- ===================== -->
                @if($user->phone)
                <div class="info-block">
                    <p class="title">My phone:</p>
                    <p class="value">{{ $user->phone }}</p>
                </div>
                @endif
                <!-- ===================== -->
                <!-- ===================== -->
                <div class="info-block">
                    @if($user->address)
                    <p class="title">My adress:</p>
                    <p class="value">{{ $user->addresss }}</p>
                    @endif
                </div>
                <!-- ===================== -->
                <!-- ===================== -->
                <div class="details">
                    <p class="title">More details:</p>
                    @if($user->details)
                    <pre>{{ $user->details }}</pre>
                    @else
                    <pre>This user likes to be a mystery</pre>
                    @endif
                </div>
                <!-- ===================== -->
                <!-- ===================== -->
                <!-- ===================== -->
                <div class="tags d-block mb-30">
                    @foreach($user->tags as $tag)
                    <a href="http://findjob.test/search?search={{ $tag }}&type=user" class="tag mb-2">{{ $tag }}</a>
                    @endforeach
                </div>
                @if($user->id == Auth::user()->id)
                <!-- ===================== -->
                <div class="submit text-right">
                    <a class="btn btn-dark text-white" href="{{ route('user.edit') }}">Change
                        your info</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($user->id == Auth::user()->id)

<!-- Jobs Created -->

<section class="cards mt-500">
    @if($user->jobs()->count())
    <h2 class="text-center font-bold mb-50">Jobs you created</h2>
    <div class="container-fluid cards-container" id="job-cards">
        <div class="row mx-auto">
            @foreach($user->jobs as $job)
            @component('jobs.job', compact('job'))
            @endcomponent
            @endforeach

        </div>
    </div>
    @endif
    @if($user->jobs()->count() < 10 && $user->id == Auth::user()->id)
        <!-- Create job button  -->
        <div class="container-fluid">
            <div>
                <a href="{{ route('job.create') }}" class="btn btn-green text-white">Create new job</a>
            </div>
        </div>
        @endif
        <!-- Create job button  -->
</section>


<!-- Applied to -->
<!-- Header -->
<div class="my-50">
    <h2 class="text-center text-dark font-bold mb-10">
        You applied to
    </h2>
    <div class="text-center">
        <small>Deleted jobs will not appear</small>
    </div>
</div>


<section class="my-50">
    <div class="container">
        <!-- Table -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <td>Job Title</td>
                        <td>Applied Date</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->applies as $job)
                    <!-- Row -->
                    <tr>
                        <td class="font-bold"><a href="{{ route('job.show', $job->slug) }}">{{ $job->title }}</a></td>
                        <td>You applied: <b>{{ $job->created_at->diffForHumans() }}</b></td>
                        <td>
                            <form action="{{ route('user.unapply', $job->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-block btn-red text-white">Unapply</button>
                            </form>
                        </td>
                    </tr>
                    <!-- /Row -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endif

@endsection



@section('script')
<script>
    if(document.querySelector("#jobs-cards > .row")){

    var macy = Macy({
            container: "#job-cards > .row",
            trueOrder: true,
            waitForImages: false,
            margin: {
                y: 60,
                x: 0
            },
                // columns: 6,
                columns: 4,
                breakAt: {
                    1920: {
                        columns: 3
                    },
                    1500: {
                        columns: 2
                    },
                    1200: {
                        columns: 1
                    }
                }
            });

        }


        // Upload user profile iamge
        $("#pic").change((e)=>{


            // The form
            let form = $("#profile-pic-form")[0];

            let formData = new FormData(form);

            $.ajax({
                method: "POST",
                url: "{{ route('user.pic') }}",
                encType: "multipart/form-data",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                xhr: ()=>{
                    let xhr = new XMLHttpRequest();

                    xhr.onprogress = (e)=>{
                        if(e.lengthComputable){
                            let percentage = parseInt((e.loaded / e.total) * 100) + '%';
                            $("#progress-bar").animate({width: percentage}, 500);
                        }
                    }
                    return xhr;
                },
                beforeSend: ()=>{
                    $("#progress").fadeIn(0);
                },
                success: (res)=>{
                    $("#progress").fadeOut(1000);
                    $("#progress-bar").delay(1000).animate({'width': '0%'},0);
                    
                    if(res.errors.length){
                        console.error(res.errors);
                    } else {
                        $("#user-pic").attr('src', res.path);
                    }

                },
                fail: (res)=>{
                    console.error(responseText);
                },
            });
    });




    // Resume
     // Upload user profile iamge
     $("#resume").change((e)=>{


        // The form
        let form = $("#resume-form")[0];

        let formData = new FormData(form);

        $.ajax({
            method: "POST",
            url: "{{ route('user.resume') }}",
            encType: "multipart/form-data",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            xhr: ()=>{
                let xhr = new XMLHttpRequest();

                xhr.onprogress = (e)=>{
                    if(e.lengthComputable){
                        let percentage = parseInt((e.loaded / e.total) * 100) + '%';
                        $("#progress-bar").animate({width: percentage}, 500);
                    }
                }
                return xhr;
            },
            beforeSend: ()=>{
                $("#progress").fadeIn(0);
            },
            success: (res)=>{
                $("#progress").fadeOut(1000);
                $("#progress-bar").delay(1000).animate({'width': '0%'},0);
                
                if(res.errors.length){
                    console.error(res.errors);
                } else {
                    $("#download-resume").attr('href', res.path);
                    $("#download-resume").css({display: 'block'});
                }

            },
            fail: (res)=>{
                console.error(responseText);
            },
        });
    });


</script>
@endsection