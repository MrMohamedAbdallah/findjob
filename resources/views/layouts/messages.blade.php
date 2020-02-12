
@if($errors->any())
<div class="mt-100 mb-0">
    @foreach($errors->all() as $error)
    <div class="alert alert-danger my-3 text-center">{{ $error }}</div>
    @endforeach
</div>
@endif

{{-- Status --}}
@if(Session::has('status'))
<div class="mt-100 mb-0">
    <div class="alert alert-primary my-3 text-center">{{ Session::get('status') }}</div>
</div>
@endif