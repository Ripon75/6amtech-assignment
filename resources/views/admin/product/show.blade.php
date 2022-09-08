@extends('welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="">
                    <strong>Name : </strong> {{ $product->name }}
                </div>
                <div class="m-2">
                    <strong>Slug : </strong> {{ $product->slug }}
                </div>
                <div class="m-2">
                    <strong>Category : </strong>{{ $product->category->name ?? '' }}
                </div>
                <div class="m-2">
                    <strong>Brand : </strong>{{ $product->brand->name ?? '' }}
                </div>
                <div class="m-2">
                    <strong>Price : </strong>{{ $product->price }}
                </div>
                <div class="m-2">
                    <strong>Selling Price : </strong> {{ $product->selling_price }}
                </div>
                <div class="m-2">
                    <strong>Tax : </strong> {{ $product->tax }}
                </div>
                <div class="m-2">
                    <strong>Quantity : </strong> {{ $product->quantity }}
                </div>
                <div class="m-2">
                    <strong>Status : </strong> {{ $product->status }}
                </div>
                <div class="m-2">
                    <strong>Description : </strong>: {{ $product->description }}
                </div>
                <div class="m-2">
                    <strong>Created At : </strong> {{ $product->created_at }}
                </div>
            </div>
        </div>
    </div>
@endsection