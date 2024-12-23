@extends('layouts.app')
@section('title', 'edit')

@section('content')
    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <p class="log">Update User Information</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label for="UserName">User name:</label>
        <input type="text" class="form-control" placeholder="enter name" value="{{ $user->name }}" id="UserName" name="UserName" required>
        <label for="UserEmail">User email:</label>
        <input type="email" class="form-control" placeholder="enter email" value="{{ $user->email }}" id="UserEmail" name="UserEmail" required>
        <label for="UserPassword">Password:</label>
        <input type="password" class="form-control" placeholder="enter password" id="UserPassword" name="UserPassword" required>
        <label for="UserPassword_confirmation">Confirm password:</label>
        <input type="password" class="form-control" placeholder="confirm password" id="UserPassword_confirmation" name="UserPassword_confirmation" required>

        <input type="submit" value="Update" class="btn btn-primary">
    </form>
@endsection
