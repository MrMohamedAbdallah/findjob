@if($paginator->hasPages())
<div class="pagination my-20">
    <ul>
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
        <li><a href="{{ $paginator->previousPageUrl() }}&type={{ Request::get('type') }}&search={{ Request::get('search') }}"><i class="fas fa-caret-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li>{{ $element }}</li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="active">{{ $page }}</li>
        @else
        <li><a href="{{ $url }}&type={{ Request::get('type') }}&search={{ Request::get('search') }}">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}&type={{ Request::get('type') }}&search={{ Request::get('search') }}"><i class="fas fa-caret-right"></i></a></li>
        @endif

    </ul>
</div>
@endif