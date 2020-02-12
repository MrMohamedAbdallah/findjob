<div class="row">
    <div class="col-md-4">
        @if(Auth::user()->hasRole('root'))
        <form action="{{ route('root.search') }}" method="GET">
        @else 
        <form action="{{ route('admin.search') }}" method="GET">
        @endif
            <label for="search">Serach:</label>
            <input type="hidden" name="type" value="{{ $type }}">
            <input name="search" id="search" type="text" />
            <button type="submit" class="btn btn-dark text-white mt-10">Search</button>
        </form>
    </div>
</div>