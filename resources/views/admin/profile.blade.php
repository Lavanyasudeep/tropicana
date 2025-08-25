@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Profile</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
                </div>

                <div class="form-group">
                    <label>Password (leave blank to keep current):</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
@stop
