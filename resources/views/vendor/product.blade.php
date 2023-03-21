@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Product Management</h2>
        <div class="mt-4">
            <a href="{{ route('vendor.product.action',['id' => 'new' ]) }}" class="btn btn-primary">Add Product</a>
            &nbsp;
            <a href="{{ route('vendor.cad.index') }}" class="btn btn-primary ml-2">Manage Categories & Brands</a>
        </div>

        <div class="mt-4">
            <form action="{{ route('vendor.product.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-
                        control" placeholder="Search Product" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th><a href="{{ route('vendor.product.index', ['sort' => 'id']) }}">ID</a></th>
                    <th>Name</th>
                    <th><a href="{{ route('vendor.product.index', ['sort' => 'quantity']) }}">Quantity</a></th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>${{ $product->price }}</td>
                        @if (count($product->productPicture) > 0)
                        <td><img src="{{ asset($product->productPicture[0]->path) }}" alt="{{ $product->name }}" style="max-height: 80px;"></td>
                        @else
                        <td>No Image</td>
                        @endif
                        <td>
                            <a href="{{ route('vendor.product.action', ['id' => $product->id, 'action' => 'edit']) }}"
                                class="btn btn-primary btn-sm">Edit</a>&nbsp;
                            <form action="{{ route('vendor.product.action', ['id' => $product->id, 'action' => 'delete']) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
        
    </div>
@endsection
