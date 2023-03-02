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
            <div class="col mb-5">
                <div class="card h-100">
                   
                    <!-- Product image-->
                    <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">Laravel book</h5>
                            <!-- Product reviews-->
                            <p>Laravel book is a good book</p>
                            <!-- Product price-->
                            <p><Strong>Price: </Strong>$99.99</p>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('cart') }}">Add to cart</a></div>
                    </div>
                </div>
            
            </div>
            <form class="d-flex">

                <div class="cart">
                    <div id="app">
                        <div class="cart-container">
                            <button class="btn btn-outline-dark" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                <!-- view all of shopping cart -->
                                <a href="{{ route('cart') }}" class="btn btn-primary btn-block">Cart</a>
                                <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
</section>
@endsection