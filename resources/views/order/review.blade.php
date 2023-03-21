@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Product Reviews</h1>
        @if ($orderProduct->count() > 0)
            @foreach ($orderProduct as $product)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">{{ $product->product->name }}</h5>
                        <p class="card-text"><small class="text-muted">{{ $order->created_at->format('F j, Y') }}</small></p>
                        <div class="d-flex align-items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="fa fa-star{{ $i <= $review->rating ? ' checked' : '' }}"></span>
                            @endfor
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $review->review }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p>No reviews yet.</p>
        @endif
        <h2>Leave a Review</h2>
        <form action="{{ route('review.store', ['id' => $order->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="form-group">
                <label for="rating">Rating:</label>
                <div class="d-flex align-items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="fa fa-star rating-star" data-rating="{{ $i }}"></span>
                    @endfor
                    <input type="hidden" name="rating" id="rating-input" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="review">Review:</label>
                <textarea class="form-control" name="review" id="review" rows="5" maxlength="150"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        // Add event listener to rating stars
        const stars = document.querySelectorAll('.rating-star');
        stars.forEach(star => {
            star.addEventListener('click', (e) => {
                const ratingInput = document.querySelector('#rating-input');
                ratingInput.value = e.target.getAttribute('data-rating');
                stars.forEach(star => {
                    star.classList.remove('checked');
                });
                e.target.classList.add('checked');
            });
        });
    </script>
@endsection
