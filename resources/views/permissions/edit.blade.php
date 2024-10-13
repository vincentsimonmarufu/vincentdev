@extends('layouts.auth.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Edit Permission</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $permission->name }}" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Permission</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
