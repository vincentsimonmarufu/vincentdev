@extends('layouts.auth.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Edit user</h3>
            </div>
            <div class="card-body">

                <div class="col-lg-12">
                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="first name" value="{{ $user->name }}" required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" name="surname" class="form-control @error('surname') is-invalid @enderror"
                                placeholder="surname" value="{{ $user->surname }}" required>
                            @error('surname')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                placeholder=" phone" value="{{ $user->phone }}">
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="user email" value="{{ $user->email }}" required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                placeholder="user address" value="{{ $user->adress }}">
                            @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                placeholder="user country" value="{{ $user->adress }}">
                            @error('country')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role">
                                <option value="">Select a role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
