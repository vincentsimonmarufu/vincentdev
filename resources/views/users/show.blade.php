@extends('layouts.auth.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{ $user->name }} {{ $user->surname }}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Phone</th>
                            <th>{{ $user->phone }}</th>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th>{{ $user->email }}</th>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <th>{{ $user->address }}</th>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <th>{{ $user->country }}</th>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <th>{{ $user->role }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection