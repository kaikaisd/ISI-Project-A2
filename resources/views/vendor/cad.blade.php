@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Categories</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <form action="{{ route('vendor.cad.category.delete', ['id' => $category->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">
                                <form action="{{ route('vendor.cad.category.add') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="text" class="form-control" name="categoryName"
                                                placeholder="Category Name">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Add Category</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h1>Brands</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    <form action="{{ route('vendor.cad.brand.delete', ['id' => $brand->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">
                                <form action="{{ route('vendor.cad.brand.add') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="text" class="form-control" name="brandName"
                                                placeholder="Brand Name">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Add Brand</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
