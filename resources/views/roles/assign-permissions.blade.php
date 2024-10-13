@extends('layouts.auth.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Assign Permissions to Role: {{ $role->name }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.permissions.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="permissions">Select Permissions</label>
                        <select id="permissions" name="permissions[]" class="form-control" multiple>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}"
                                    {{ $role->hasPermissionTo($permission->name) ? 'selected' : '' }}>
                                    {{ $permission->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign Permissions</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        // Optional: Initialize a select2 or similar plugin if you want nicer UI
        $(document).ready(function() {
            $('#permissions').select2({
                placeholder: "Select permissions",
                allowClear: true
            });
        });
    </script>
@endsection
@endsection
