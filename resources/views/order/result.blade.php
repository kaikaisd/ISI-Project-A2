@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            @if ($result === 'success')
                <i class="fas fa-check-circle text-success" style="font-size: 8rem;"></i>
                <h2>Order Successful!</h2>
                <h3>Your Order ID is {{ $orderId }}</h3>
                <p>Thank you for shopping with us. We will contact you soon.</p>
        </div>
        <a href="{{ route('order.detail', ['id' => $orderId]) }}" class="btn btn-primary">View Order</a>

            @else
                <i class="fas fa-times-circle text-danger" style="font-size: 8rem;"></i>
                <h2>Order Failed.</h2>
                <p>{{ $message }}</p>
    </div>
            @endif
            
        </div>
    </div>
@endsection
