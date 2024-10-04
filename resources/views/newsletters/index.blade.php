@extends('layouts.auth.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h1>Newsletter subscribers</h1>
    </div>
    <div class="card-body">
        @if ($newsletters->count() > 0)
        <div class="table-responsive">
            <table id="example2" data-order='[[ 0, "asc" ]]' class="table table-striped table-bordered table-hover">
                <thead>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($newsletters as $newsletter)
                    <tr>
                        <td>{{$newsletter->fullname}}</td>
                        <td>{{$newsletter->email}}</td>
                        <td>
                            {!!Form::open(['action'=>['App\Http\Controllers\NewsletterController@destroy', $newsletter->id], 'method'=>'DELETE'])!!}
                            {{Form::submit('Unsubscribe', ['class'=>'btn btn-danger'])}}
                            {!!Form::close()!!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-success">There are no users that signed up for newsletters yet!</p>
        @endif
    </div>
</div>
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#dtBasicExample').DataTable();
    });
</script>
@endsection
@endsection