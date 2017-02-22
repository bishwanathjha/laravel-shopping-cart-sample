@extends('main')

@section('content')
    @include('admin.sidebar')

    <div class="row col-md-8 col-md-offset-1" style="margin-left: 0px;">
    <table class="table table-striped custab">
        <div class="alert" style="display: none" id="notify">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <p id="notify-msg"></p>
        </div>
        <thead>
        <a href="{{ URL::to('admin/users/add') }}" class="btn btn-primary btn-xs pull-right"><b>+</b> Add new user</a>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Created at</th>
            <th>Last login at</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        @foreach($users['data'] as $user)
            <tr id="user-{{$user['id']}}">
                <td>{{ $user['name'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['created_at'] }}</td>
                <td>{{ $user['last_login_at'] }}</td>
                <td class="text-center"><a class='btn btn-info btn-xs' onclick="editUser({{$user['id']}})" href="Javascript:void();"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="Javascript:void();" onclick="deleteUser({{$user['id']}});" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
