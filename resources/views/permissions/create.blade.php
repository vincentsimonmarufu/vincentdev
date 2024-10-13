@extends('layouts.auth.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Add Permission</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Permission</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
