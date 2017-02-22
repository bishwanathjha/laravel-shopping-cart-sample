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
            <th>Title</th>
            <th>original_price</th>
            <th>in_stock</th>
            <th>quantity</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        @foreach($products['data'] as $product)
            <tr id="product-{{$product['id']}}">
                <td>{{ $product['title'] }}</td>
                <td>{{ $product['original_price'] }}</td>
                <td>{{ $product['in_stock'] }}</td>
                <td>{{ $product['quantity'] }}</td>
                <td class="text-center"><a class='btn btn-info btn-xs' onclick="editProduct({{$product['id']}})" href="Javascript:void()"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="Javascript:void()" onclick="deleteProduct({{$product['id']}});" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
