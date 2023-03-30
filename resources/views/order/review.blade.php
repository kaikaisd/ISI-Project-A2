@extends('layouts.app')
@section('title', 'Reviews')
@section('content')
    <div class="container">
        <h1>Reviews</h1>
        <form action="{{ route('review.store', ['id' => $order->id]) }}" method="POST">
            @csrf
                {{-- @php
                    dd($reviews->all());
                @endphp --}}
        <div class="row">
            @foreach ($orderProduct as $key => $product)
                
                <div class="col-md-3">
                    
                        <div class="card mb-3">
                            <div class="card-header">
                                <input hidden name="order_id" value="{{ request('id') }}">
                                <input hidden name="product_id[{{ $product->product->id }}]" value="{{ $product->product->id }}">
                                <img class="card-img-top" src="{{ asset($product->product->productPicture[0]->path) }}"
                                    alt="{{ $product->product->name }}">


                            </div>
                            <div class="card-body">
                                
                                <h5 class="card-title">{{ $product->product->name }}</h5>
                                <p class="card-text"><small
                                        class="text-muted">{{ $order->created_at->format('F j, Y') }}</small></p>
                                <div class="d-flex align-items-center">
                                    <input type="hidden" class="rating" name="rating[{{ $product->product->id }}]"
                                        data-empty="fa-regular fa-star fa-xl" value="{{ $reviews[$product->product->id]->rating ?? 5 }}" data-filled="fa-solid fa-star fa-xl" style="color: gold;" data-start="0" data-stop="5" />
                                </div>
                                <div class="form-group">
                                    <label for="review">Review:</label>
                                    <textarea class="form-control" name="reviews[{{ $product->product->id }}]" id="review" rows="5"
                                        maxlength="150" value="{{ $reviews[$product->product->id]->reviews ?? '' }}" ></textarea>
                                </div>
                            </div>
                        </div>
                </div>
            @endforeach
            <br />

            <div class="d-grid gap-2">
                <button type="submit" class=" btn btn-primary">Submit</button>
            </div>

        </div>
        </form>
    </div>
@endsection
