@extends('layouts.app')
@section('title', 'Order Details')
@php
    $color = '';
    if ($order->status == 'Pending') {
        $color = 'text-success';
    } elseif ($order->status == 'On Hold') {
        $color = 'text-warning';
    } elseif ($order->status == 'Completed') {
        $color = 'text-primary';
    }
@endphp
@section('content')
    <div class="container">
        <h2>Order Form</h2>
        <div class="">
            @if ($order->status == 'Delivered')
                <a href="{{ route('order.review', ['id' => $order->id]) }}" class="text-start btn btn-primary">Review
                    Order</a>
            @endif
            <h3 class="text-end">Order ID: {{ $order->id }}</h3>
            <h3 class="text-end">Order Status: <span class="{{ $color }}">{{ $order->status }}</span>
                <h3 class="text-end">Order created at: {{ $order->created_at }}</h3>
                <h3 class="text-end">Last Updated: {{ $order->updated_at }}</span>
                    @if ($order->status == 'Cancelled')
                        <h3 class="text-end">Action by: {{ $order->updater == 0 ? 'User' : 'Vendor' }}</h3>
                    @endif
        </div>
        </h3>
        <div class="row mt-4">
            <div class="col-md-6">

                <h4>User Details:</h4>

                <table class="table">
                    <tbody>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $order->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $order->user->address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h4>Order Details</h4>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderProduct as $item)
                            <tr style="{{ $item->product->quantity < 0 ? 'background-color: yellow; ' : '' }}">
                                <td>{{ $item->product->id }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ $item->price }}</td>
                                <td>${{ $item->quantity * $item->price }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                            @php
                                $sum = 0;
                                foreach ($order->orderProduct as $item) {
                                    $sum += $item->quantity * $item->price;
                                }
                            @endphp
                            <td><strong>${{ $sum }}</strong></d>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <br /><br />
            </div>
        </div>
        @if ($order->status == 'Pending' || $order->status == 'On Hold')
            <div class="fixed-bottom mb-4">
                <div class="d-flex justify-content-center ">
                    <button type="button" class="btn btn-lg btn-danger mr-4" onclick="cancelOrder()">Cancel
                        Order</button>
                </div>
            </div>
        @endif
    </div>

@endsection
@section('scripts')
    <script>
        function cancelOrder() {
            if (confirm('Are you sure you want to cancel this order?')) {
                $.ajax({
                    url: "{{ route('order.cancel', ['id' => $order->id]) }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        window.location.href = "{{ $order->id }}";
                    }
                });
            }
        }
    </script>
@endsection
