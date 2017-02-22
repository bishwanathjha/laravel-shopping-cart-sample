@extends('main')
@section('title', 'Home')

@section('content')
    <header>
        <div class="row">
            <div class="btn-group btn-breadcrumb">
                <a href="{{ URL::to('/') }}" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                <a href="#" class="btn btn-default">{{ $product['title'] }}</a>
            </div>
        </div>
    </header>

<div class="card">
    <div class="container-fliud">
        <div class="wrapper row">
            <div class="preview col-md-6">
                <div class="preview-pic tab-content">
                    <div class="tab-pane active" id="pic-1"><img width="200" height="400" src="{{ $product['image'] }}" /></div>
                </div>
            </div>
            <div class="details col-md-6">
                <h3 class="product-title">{{ $product['title'] }}</h3>
                <p class="product-description">{{ $product['description'] }}</p>
                <h4 class="price">current price: <span>${{ $product['actual_price'] }}</span> <span style="text-decoration: line-through;" >${{ $product['original_price'] }}</span></h4>
                <h5 class="sizes">Cateogy:
                    <span>{{ $product['category'] }}</span>
                </h5>
                <p>
                    <a id="add-cart-{{$product['id']}}" href="Javascript:void(0)" onclick="addToCart({{$product['id']}})" class="btn btn-primary">Add to cart!</a>
                    <div class="alert" style="display: none" id="notify-{{$product['id']}}">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                <p id="notify-msg"></p>
            </div>
            </p>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<hr>
@endsection