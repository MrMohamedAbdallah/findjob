@extends('layouts.basic')

@section('title')
{{ Request::get('search') }}
@endsection

{{-- Header --}}
@include('layouts.header')
{{-- /Header --}}


{{-- Content --}}
@section('content')

<section class="cards mt-150">
  <div class="container-fluid cards-container" id="employees-cards">
    @if(count($users) == 0)
    <h2 class="font-bold text-black text-center mb-0 mt-100">
      Nothing matches your search
    </h2>
    @else
    <div class="row mx-auto">
      @foreach ($users as $user)
      <!-- Card -->
      @component('user', ['user' => $user])
      @endcomponent
      <!-- Card -->
      @endforeach
      @endif

    </div>
  </div>
  <div class="container-fluid">
    <div class="my-10 text-center">{{ $users->links('pagination') }}</div>
  </div>
</section>

@endsection
{{-- /Content --}}


{{-- Script --}}
@section('script')
<script>
  var employees = Macy({
        container: "#employees-cards > .row",
        trueOrder: true,
        waitForImages: false,
        margin: {
          y: 0,
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