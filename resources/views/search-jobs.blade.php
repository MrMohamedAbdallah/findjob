@extends('layouts.basic')

@section('title')
{{ Request::get('search') }}
@endsection

{{-- Header --}}
@include('layouts.header')
{{-- /Header --}}


{{-- Content --}}
@section('content')

<section class="cards mt-100">
    <div class="container-fluid cards-container" id="job-cards">
        @if(count($jobs) == 0)
        <h2 class="font-bold text-black text-center mb-0 mt-100">
            Nothing matches your search
        </h2>
        @else
        <div class="row mx-auto">
            @foreach($jobs as $job)
            <!-- Card -->
            @component('jobs.job', ['job' => $job])
            @endcomponent
            <!-- Card -->
            @endforeach
            @endif

        </div>
    </div>
</section>
@endsection
{{-- /Content --}}


{{-- Script --}}
@section('script')
<script>
    var macy = Macy({
              container: "#job-cards > .row",
              trueOrder: true,
              waitForImages: false,
              margin: {
                y: 60,
                x: 30
              },
              // columns: 6,
              columns: 4,
              breakAt: {
                1920: 3,
                1450: 2,
                750: 1
              }
            });
</script>
@endsection
{{-- /Script --}}