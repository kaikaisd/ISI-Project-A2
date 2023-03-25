@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Products</h2>

        <form action="{{ route('index') }}" method="GET">
            <input type="hidden" name="search" value="{{ request()->get('search') }}">
            <div class="form-group">
                <label for="brand">Filter by Brand:</label>
                <select class="form-control" id="brand" name="brand">
                    <option value="all">All Brands</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request()->get('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <br />
            <div class="form-group">
                <!-- sort by price !-->
                <label for="price">Sort by Price:</label>
                <select class="form-control" id="price" name="price">
                    <option value="asc" {{ request()->get('price') == 'asc' ? 'selected' : '' }}>Low to High</option>
                    <option value="desc" {{ request()->get('price') == 'desc' ? 'selected' : '' }}>High to Low</option>
                </select>
            </div>
            <br />
            <div class="d-grid gap-2">
                <button type="submit" class=" btn btn-primary">Filter</button>
            </div>
        </form>

        <br /><br />
        <div class="row">
            @if (count($products) == 0)
                <div class="col-md-12">
                    <div class="alert alert-info">
                        No products found
                    </div>
                </div>
            @else
                @foreach ($products as $product)
                    <div class="col-md-3">
                        <div class="card">
                            @php
                                $productPicture = $product->productPicture->sortBy('order') ;
                                //  dd($productPicture);
                            @endphp
                            @if ($product->productPicture->sortBy('order')->count() > 0)
                                <img class="card-img-top"
                                    src="{{ asset($productPicture[0]->path) }}"
                                    alt="{{ $product->name }}"
                                    data-order="{{ $product->productPicture->sortBy('order')[0]->id }}">
                            @else
                                <h3>No Image</h3>
                            @endif
                            <div class="card-body">
                                <h4 class="card-title">{{ $product->name }}</h4>
                                <h6 class="card-title">Brand: {{ $product->brand->name }}</h6>
                                @if ($product->isPromotion)
                                    <p class="card-text"><del>${{ $product->price }}</del></p>
                                    <p class="card-text" style="font-size: 28px; color:red; font-weight: bold;">
                                        ${{ $product->promoPrice }}</p>
                                @else
                                    <p class="card-text" style="font-size: 28px; font-weight: bold;">${{ $product->price }}
                                    </p>
                                @endif
                                @guest
                                @else
                                    @if ($product->isOnSale == 1)
                                        <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa-solid fa-cart-plus"></i></button>
                                        </form>
                                    @endif
                                @endguest
                                <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="btn btn-primary"><i
                                        class="fa-solid fa-eye"></i></a>
                            </div>
                        </div>
                        <br />
                    </div>
                @endforeach
            @endif
        </div>

        <div class="d-flex">
            <div class="mx-auto">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
