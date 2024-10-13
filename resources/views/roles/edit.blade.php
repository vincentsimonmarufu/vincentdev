@extends('layouts.auth.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Edit Role</h3>
            </div>
            <div class="card-body">

                <div class="col-lg-12">
                    <form action="{{ route('roles.update', $role->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Role name" value="{{ $role->name }}" required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
