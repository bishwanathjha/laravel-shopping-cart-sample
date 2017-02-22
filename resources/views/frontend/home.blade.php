@extends('main')
@section('title', 'Home')

@section('content')
<!-- Jumbotron Header -->
<header>
    <h1>Laravel E-Commerce application!</h1>
</header>

<hr>

<!-- Title -->
<div class="row">
    <div class="col-lg-12">
        <h3>Products</h3>
    </div>
</div>
<!-- /.row -->

    <!-- Page Features -->
    <div class="row text-center">
        @foreach ($products['data'] as $product)
        <div class="col-md-2 col-sm-6 hero-feature">
            <div class="thumbnail">
                <a href="{{ URL::to('products') . '/' .$product['id'] .'-'. str_slug($product['title']) }}">
                    <img style="width: 150px; height: 150px;" src="@if(!empty($product['image'])) {{ $product['image'] }} @else http://placehold.it/800x500 @endif" alt="">
                </a>
                <div class="caption">
                    <h3>{{ $product['title'] }}</h3>
                    <p>{{ $product['description'] }}</p>
                    <span class="btn btn-primary">Price: ${{ $product['original_price'] }}</span>
                    <p>
                        <a id="add-cart-{{$product['id']}}" href="Javascript:void(0)" onclick="addToCart({{$product['id']}})" class="btn btn-primary">Add to cart!</a> <a href="{{ URL::to('products') . '/' .$product['id'] .'-'. str_slug($product['title']) }}" class="btn btn-default">View Details</a>
                    <div class="alert" style="display: none" id="notify-{{$product['id']}}">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <p id="notify-msg"></p>
                    </div>
                    </p>

                </div>
            </div>
        </div>
        @endforeach
    </div>

@if ($products['total_pages'] > 1 )
    <div class="container">
        <ul class="pagination">
            <li><a href="@if($products['current_page'] > 1) {{ URL::to('?page=' . ($products['current_page'] -1)) }} @else Javascript:void @endif"><< Previous</a></li>
            <li class="active"><a href="Javascript:void(0)" class="active">{{ $products['current_page'] }}</a></li>
            <li><a href="@if($products['current_page'] < $products['total_pages']) {{ URL::to('?page=' . ($products['current_page'] +1)) }} @else Javascript:void @endif">Next >> </a></li>
        </ul>
    </div>
@endif

<!-- /.row -->
<hr>
@endsection