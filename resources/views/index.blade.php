@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Products</h2>

        <form action="{{ route('index') }}" method="GET">
            <div class="form-group">
                <label for="brand">Filter by Brand:</label>
                <select class="form-control" id="brand" name="brand">
                    <option value="all">All Brands</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request()->get('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <br/>
            <div class="d-grid gap-2">
                <button type="submit" class=" btn btn-primary">Filter</button>
            </div>
        </form>

        <br /><br />
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card">
                        <img class="card-img-top" src="{{ $product->productPicture[0]->path }}" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h4 class="card-title">{{ $product->name }}</h4>
                            <p class="card-text">${{ $product->price }}</p>
                            @guest
                                <a href = "{{ route('login') }}" class="btn btn-primary">Login</a> 
                            @else
                            <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                            @endguest
                            &nbsp;
                            <a href = "{{ route('product.detail', ['id' => $product->id]) }}" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                    <br />
                </div>
            @endforeach
        </div>

        <div class="d-flex">
            <div class="mx-auto">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
