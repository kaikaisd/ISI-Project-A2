@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>品牌</h3>
                {{--  <form action="{{ route('products.index') }}" method="get">
                    <div class="form-group">
                        <select name="brand" class="form-control" onchange="this.form.submit()">
                            <option value="">全部</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $brand->id == $selectedBrand ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>  --}}
            </div>
            <div class="col-md-9">
                <h3>產品列表</h3>

                @foreach ($products as $product)
                    <div>{{ $product->name }}</div>
                @endforeach

                {{--  <form action="{{ route('products.index') }}" method="get">
                    <div class="form-group">
                        <input type="text" name="keyword" class="form-control" placeholder="搜索產品名稱" value="{{ $keyword }}">
                    </div>
                    <button type="submit" class="btn btn-primary">搜索</button>
                </form>  --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th>產品名稱</th>
                            <th>品牌</th>
                            <th>價格</th>
                            <th>縮圖</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{--  @foreach ($products as $product)  --}}
                            {{--  <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->brand->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td><img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" width="50"></td>
                            </tr>  --}}
                        {{--  @endforeach  --}}
                    </tbody>
                </table>
                {{--  {{ $products->appends(['brand' => $selectedBrand, 'keyword' => $keyword])->links() }}  --}}
            </div>
        </div>
    </div>
@endsection
