@extends('layouts.basic')

{{-- Header --}}
@include('layouts.header')
{{-- /Header --}}


{{-- Content --}}
@section('content')

<section class="cards mt-100">
    <div class="container-fluid cards-container" id="job-cards">
        @if(count($jobs) == 0)
        <h2 class="font-bold text-black text-center mb-30 mt-100">
            Nothing here for you yet
        </h2>
        @else
        <h2 class="font-bold text-black text-center mb-30 mt-100">
            Our suggestion for you
        </h2>
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
    <div class="container-fluid">
        <div class="my-10 text-center">{{ $jobs->links('pagination') }}</div>
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