@extends('layouts.app')
@section('title', 'product list')

@section('content')
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Welcome</h1>
            <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <div class="col mb-5">
                <div class="card h-40">
                    @foreach($products as $product)
                    <!-- Product image-->
                    <img class="card-img-top" src=" {{ $product->image }} " alt=" " width="20" height="20">
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{ $product->name }}</h5>
                            <!-- Product reviews-->
                            <p>{{ $product->description}}</p>
                            <!-- Product price-->
                            <p><Strong>Price: </Strong>{{ $product->price }}$</p>
                        </div>

                    </div>
                    <!-- Product actions-->
                    <form action="{{ route('cart.add', $product->id ) }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button class="button-hover-addcart button"><span>Add to cart</span><img
                                src="{{ asset('images/shopping-cart-add.svg') }}" width="20" height="20"
                                class="img-responsive">
                        </button>
                    </form>
                </div>

            </div>
            @endforeach
        </div>
   

        <form class="d-flex">
            <div class="cart">
                <div id="app">
                    <div class="cart-container">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            <!-- view all of shopping cart -->
                            <img src="https://img.icons8.com/ios/50/000000/shopping-cart.png" width="30" height="30"
                                class="img-responsive" />
                            <a href="{{ route('cart.index') }}" class="btn btn-primary btn-block">Cart</a>
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
</section>