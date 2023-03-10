@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                {{-- <div id="product-images" class="mb-4">
                    <div class="product-main-image">
                        <img src="{{ $product->productPicture[0]->path }}" alt="{{ $product->name }}" class="img-fluid">

                    </div>
                    <div class="product-thumbnails mt-2">
                        @foreach ($product->productPicture as $image)
                            <div class="thumbnail">
                                <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" class="img-fluid">
                            </div>
                        @endforeach
                    </div>
                </div> --}}
                <div id="product-images" class="mb-4">
                    <div id="product-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($product->productPicture as $index => $image)
                                <li data-target="#product-carousel" data-slide-to="{{ $index }}"
                                    class="{{ $index == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($product->productPicture as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ $image->path }}" alt="{{ $product->name }}" class="img-fluid">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

                <div class="col-md-6">
                    <h1>{{ $product->name }}</h1>

                    @if ($product->isOnSale === 1)
                        <div class="alert alert-success d-inline-block">On Sale</div>
                    @else
                        <div class="alert alert-danger d-inline-block">Not On Sale</div>
                    @endif

                    <table class="table mt-3">
                        <tbody>
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

                        @if (auth()->check())
                            <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-block">Log In to Add to Cart</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            $('#product-carousel').carousel();
        </script>
    @endsection
