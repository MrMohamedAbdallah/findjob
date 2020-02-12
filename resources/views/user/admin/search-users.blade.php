@extends('layouts.basic')



@section('content')

<div class="panel-container">
    <div class="container-fluid mt-100">
        <h1 class="text-center mb-10 font-bold">Users</h1>
        <p class="text-center mb-40"><b>Search for: </b><small>{{ $searchTerm }}</small></p>
        @component('user.admin.search', ['type' => 'user'])
        @endcomponent

        <!-- Table -->
        <div class="table-wrapper mt-30">
            <table>
                <thead>
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Age</td>
                        <td>Applies</td>
                        <td>Jobs</td>
                        <td>Action</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <!-- Row -->
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><a
                                href="{{ route('user.profile', $user->slug) }}">{{ $user->first . ' ' . $user->last }}</a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->birth_date->age }}</td>
                        <td>{{ $user->jobs()->count() }}</td>
                        <td>{{ $user->jobs()->count() }}</td>
                        <td>
                            @if(Auth::user()->hasRole('root'))
                            <form action="{{ route('root.edit', $user->id) }}" method="POST"
                                id="edit-form{{ $user->id }}">
                                @else
                                <form action="{{ route('admin.edit', $user->id) }}" method="POST"
                                    id="edit-form{{ $user->id }}">
                                    @endif
                                    @csrf
                                    @method('PUT')
                                    @foreach($roles as $id => $name)
                                    <div>
                                        <input type="checkbox" class="checkbox-sm" value="{{ $name }}" name="roles[]"
                                            id="role{{ $id }}" @if($user->hasRole($name)) checked @endif>
                                        <label for="role{{ $id }}">{{ $name }}</label>
                                    </div>
                                    @endforeach
                                </form>
                        </td>
                        <td class="d-flex">
                            <button class="btn btn-dark mr-2"
                                onclick="document.getElementById('edit-form{{ $user->id }}').submit()">Edit</button>
                            @if(Auth::user()->hasRole('root'))
                            <form action="{{ route('root.delete', $user->id) }}" class="d-inilne" method="POST">
                                @else
                                <form action="{{ route('admin.delete', $user->id) }}" class="d-inilne" method="POST">
                                    @endif
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you wnat to delete that user')"
                                        class="btn btn-danger text-white font-bold">
                                        Delete
                                    </button>
                                </form>
                        </td>
                    </tr>
                    <!-- /Row -->
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="my-10 text-center">{{ $users->links('pagination') }}</div>
    </div>
</div>


@component('layouts.sidebar')
@endcomponent

@endsection