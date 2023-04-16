@extends('layouts.app')
@section('title', 'Product Management')

@section('content')
    <div class="container">
        <h2>Product Management</h2>
        <div class="mt-4">
            <a href="{{ route('vendor.product.action', ['id' => 'new']) }}" class="btn btn-primary">Add Product</a>
            &nbsp;
            <a href="{{ route('vendor.cad.index') }}" class="btn btn-primary ml-2">Manage Categories & Brands</a>
            &nbsp;
            <a href="{{ route('vendor.product.index') }}" class="btn btn-secondary ml-2">Reset Filter</a>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('vendor.product.index') }}" method="GET">
                    <input hidden name="searchID" value="{{ request('searchID') ?? '' }}">
                    <input hidden name="searchName" value="{{ request('searchName') ?? '' }}">

                    <div class="form-group">
                        <label for="brand">Filter by Brand:</label>
                        <select class="form-control" id="brand" name="brand">
                            <option value="all">All Brands</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ request()->get('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <br />
                    <div class="form-group">
                        <!-- sort by price !-->
                        <label for="price">Sort by original Price:</label>
                        <select class="form-control" id="price" name="price">
                            <option value="asc" {{ request()->get('price') == 'asc' ? 'selected' : '' }}>Low to High
                            </option>
                            <option value="desc" {{ request()->get('price') == 'desc' ? 'selected' : '' }}>High to Low
                            </option>
                        </select>
                    </div>
                    <br />
                    <div class="d-grid gap-2">
                        <button type="submit" class=" btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <form action="{{ route('vendor.product.index') }}" method="GET">
                    <input hidden name="brand" value="{{ request('brand') ?? 'all' }}">
                    <input hidden name="price" value="{{ request('price') ?? 'asc' }}">
                    <div class="form-group">
                        <label for="search">Search product by id:</label>
                        <input type="text" id="searchID" name="searchID" class="form-control"
                            placeholder="Search Product" value="{{ request('searchID') }}">
                    </div>
                    <br/>
                    <div class="form-group">
                        <label for="search">Search product by name:</label>
                        <input type="text" id="searchName" name="searchName" class="form-control"
                            placeholder="Search Product" value="{{ request('searchName') }}">
                    </div>
                    <br />
                    <div class="d-grid gap-2">
                        <button type="submit" class=" btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
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
                            @if ($product->productPicture->count() > 0)
                                <img class="card-img-top" src="{{ asset($product->productPicture[0]->path) }}"
                                    alt="{{ $product->name }}">
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
                                <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="btn btn-primary"><i
                                        class="fa-solid fa-eye"></i></a>&nbsp;
                                <a href="{{ route('vendor.product.action', ['id' => $product->id, 'action' => 'edit']) }}"
                                    class="btn btn-primary btn-sm">Edit</a>&nbsp;
                                <form
                                    action="{{ route('vendor.product.action', ['id' => $product->id, 'action' => 'delete']) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
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
