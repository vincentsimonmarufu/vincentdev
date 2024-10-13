@extends('layouts.auth.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>All Roles</h3>
                <a href="{{ route('roles.create') }}" class="btn btn-primary">Add Role</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                        <thead>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        <a href="{{ route('roles.permissions.edit', $role->id) }}"
                                            class="btn btn-info">Assign Permissions</a>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-success">Edit</a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this role: {{ $role->name }}?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
