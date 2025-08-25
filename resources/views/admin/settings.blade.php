@extends('adminlte::page')

@section('title', 'Admin Settings')

@section('content_header')
    <h1>Admin Panel Settings</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Customize Admin Panel</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf

                <!-- Theme Mode -->
                <div class="form-group">
                    <label>Theme Mode:</label>
                    <select name="theme_mode" class="form-control">
                        <option value="light" {{ session('theme_mode') == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark" {{ session('theme_mode') == 'dark' ? 'selected' : '' }}>Dark</option>
                    </select>
                </div>

                <!-- Layout Options -->
                <h5 class="mt-4">Layout Options</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="layout_topnav" id="layout_topnav" {{ session('layout_topnav') == 'on' ? 'checked' : '' }}>
                    <label class="form-check-label" for="layout_topnav">Enable Top Navigation</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="layout_fixed_sidebar" id="layout_fixed_sidebar" {{ session('layout_fixed_sidebar') == 'on' ? 'checked' : '' }}>
                    <label class="form-check-label" for="layout_fixed_sidebar">Fixed Sidebar</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="layout_fixed_navbar" id="layout_fixed_navbar" {{ session('layout_fixed_navbar') == 'on' ? 'checked' : '' }}>
                    <label class="form-check-label" for="layout_fixed_navbar">Fixed Navbar</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="layout_fixed_footer" id="layout_fixed_footer" {{ session('layout_fixed_footer') == 'on' ? 'checked' : '' }}>
                    <label class="form-check-label" for="layout_fixed_footer">Fixed Footer</label>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
            </form>
        </div>
    </div>
@stop
