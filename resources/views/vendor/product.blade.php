@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Product Management</h2>

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
                        <td><img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="max-height: 20px;"></td>
                        <td>
                            <a href="{{ route('vendor.product.edit', ['id' => $product->id]) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('vendor.product.destroy', ['id' => $product->id]) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <a href="{{ route('vendor.product.create') }}" class="btn btn-primary">Add Product</a>
        </div>
    </div>
@endsection
