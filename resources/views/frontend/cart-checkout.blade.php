@extends('main')
@section('title', 'Home')

@section('content')
    <!-- Jumbotron Header -->
    <header>
        <div class="row">
            <div class="btn-group btn-breadcrumb">
                <a href="{{ URL::to('/') }}" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                <a href="#" class="btn btn-default">My cart checkout</a>
            </div>
        </div>
    </header>

    <hr>
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Total</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr id="item-{{ $product['id'] }}">
                        <td class="col-md-8">
                            <div class="media">
                                <img class=" thumbnail pull-left media-object" src="{{ $product['image'] }}" style="width: 72px; height: 72px;">
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="#">{{ $product['product_name'] }}</a></h4>
                                    <h5 class="media-heading"><p class="small">{{ $product['product_desc'] }}</p></h5>
                                </div>
                            </div></td>
                        <td class="col-md-2" style="text-align: center">
                            <span>{{ $product['quantity'] }}</span>
                        </td>
                        <td class="col-md-2 text-center"><strong id="{{ "unit-" . $product['id'] }}">{{ $product['unit_price'] }}</strong></td>
                        <td class="col-md-2 text-center"><strong id="{{ "total-" . $product['id'] }}">{{ $product['unit_price'] }}</strong></td>
                    </tr>
                @endforeach
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h3>Total</h3></td>
                    <td class="text-right"><h3><strong id="grand-total"></strong></h3></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>

                    <td>
                        <a href="Javascript:alert('This page need implementation')">
                            <button type="button" class="btn btn-success">
                                Payment <span class="glyphicon glyphicon-play"></span>
                            </button>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.row -->
    <hr>
@endsection