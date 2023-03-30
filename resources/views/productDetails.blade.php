@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="product-images" class="mb-4">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="true">
                        <div class="carousel-indicators">
                            @foreach ($product->productPicture as $index => $image)
                                <button type="button" data-bs-target="#product-carousel"
                                    aria-label="Slide {{ $index + 1 }}" data-bs-slide-to="{{ $index }}"
                                    class="{{ $index == 0 ? 'active' : '' }}"
                                    {{ $index == 0 ? 'aria-current="true"' : '' }}></li>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($product->productPicture->sortBy('order') as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" class="d-block w-100">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" data-bs-target="#product-carousel" type="button"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" data-bs-target="#product-carousel" type="button"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
                <div class="d-flex align-items-center">
                    <h4 class="text-bold">Rating:</h4>&nbsp;
                    <input type="hidden" class="rating" data-empty="fa-regular fa-star fa-xl"
                        data-filled="fa-solid fa-star fa-xl" style="color: gold;" data-start="0" data-stop="5"
                        value="{{ $avgRating }}" readonly>
                </div>
                <br>
                @if ($product->isPromotion == 1)
                    <h4 class=""><del>${{ $product->price }}</del></h3>
                        <h2 class="text-danger text-bold">${{ $product->promoPrice }}</h2>
                    @else
                        <h2 class="text-success">${{ $product->price }}</h2>
                @endif
                @if ($product->isOnSale === 1)
                    @if ($product->quantity >= 1)
                        <div class="alert alert-success d-inline-block">On Sale</div>
                    @else
                        <div class="alert alert-danger d-inline-block">Out of Stock</div>
                    @endif
                @else
                    <div class="alert alert-danger d-inline-block">Not On Sale</div>
                @endif

                <table class="table mt-3">
                    <tbody>
                        <tr>
                            <td>Brand:</td>
                            <td>{{ $product->brand->name }}</td>
                        </tr>
                        <tr>
                            <td>Category:</td>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <td>ISBN:</td>
                            <td>{{ $product->isbn }}</td>
                        </tr>
                        <tr>
                            <td>Author:</td>
                            <td>{{ $product->author }}</td>
                        </tr>
                        <tr>
                            <td>Publisher:</td>
                            <td>{{ $product->publisher }}</td>
                        </tr>
                        <tr>
                            <td>Pages:</td>
                            <td>{{ $product->pages }}</td>
                        </tr>
                    </tbody>
                </table>

                <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="mt-4">
                    @csrf

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="1"
                            min="1">
                    </div>
                    <br />
                    @if (auth()->check())
                        @if ($product->isOnSale == 1)
                            @if (auth()->user()->role == 2)
                                
                            @else
                            <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-block">Log In to Add to Cart</a>
                    @endif
                </form>
                <br/>

                <ul class="list-group">
                    @foreach ($review as $review)
                        <li class="list-group-item">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $review->user->name }}</div>
                                {{ $review->reviews }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#product-carousel').carousel();
    </script>
@endsection
