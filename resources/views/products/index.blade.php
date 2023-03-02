@extends('layouts.app')
@section('title', 'product list')

@section('content')
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
            <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @foreach($products as $product)
            <div class="col mb-5">
                <div class="card h-100">
                    <a href="{{ route('products.show', $product->id) }}"><img class="card-img-top"
                            src="{{ asset('storage/' . $product->pic) }}" alt="..." /></a>
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h5 class="fw-bolder">{{ $product->name }}</h5>
                            <p>{{ $product->description }}</p>
                            <p>{{ $product->price }}</p>
                            <p>{{ $product->quantity }}</p>
                            <p>{{ $product->isOnSale }}</p>
                            <p>{{ $product->isOverSale }}</p>
                            <p>{{ $product->isPromotion }}</p>
                            <p>{{ $product->promoPrice }}</p>
                            <p>{{ $product->brand->name }}</p>
                            <p>{{ $product->category->name }}</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-dark mt-auto" type="submit">Add to cart</button>
                            </form>
                        </div>
                    </div>
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
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                    <div class="dropdown-menu">
                        <div class="row total-header-section">
                            <div class="col-lg-6 col-sm-6 col-6">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span
                                    class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                            </div>
                            @php $total = 0 @endphp
                            @foreach((array) session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            @endforeach
                            <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                <p>Total: <span class="text-info">$ {{ $total }}</span></p>
                            </div>
                        </div>
                        @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                        <div class="row cart-detail">
                            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                <img src="{{ $details['image'] }}" />
                            </div>
                            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                <p>{{ $details['name'] }}</p>
                                <span class="price text-info"> ${{ $details['price'] }}</span> <span class="count">
                                    Quantity:{{ $details['quantity'] }}</span>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                <a href="{{ route('cart') }}" class="btn btn-primary btn-block">View all</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
</section>
@endsection