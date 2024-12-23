@extends('layouts.app')

@section('title', 'UsersTable')

@section('content')
    @php

    @endphp
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">Update User</th>
                <th scope="col">Delete User</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @forelse ($users as $user)
                @if (!$user->is_admin)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td><a href='{{ route('user.edit', $user->id) }}'><button type="button"
                                    class="btn btn-success">Update</button></a></td>
                        <td>

                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                        </td>

                    </tr>
                @endif
            @empty
                </tr>
                <tr>
                    <td colspan="6">There are no users</td>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('user.create') }}"><button type="button" class="btn btn-secondary">Create New User
        </button></a>
    <a href="{{ route('posts.index') }}"><button type="button" class="btn btn-secondary">Return to posts
        </button></a>

@endsection
