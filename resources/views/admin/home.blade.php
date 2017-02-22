@extends('main')

@section('content')
    <div class="row">
        @include('admin.sidebar')
        <div class="col-sm-9 col-md-9">
            <div class="well">
                <h1>Welcome to admin panel</h1>
                You can add new product or create new users and modify them.
            </div>
        </div>
    </div>
@endsection
