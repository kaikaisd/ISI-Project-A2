@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Order Detail</h2>

        <div class="row mt-4">
            <div class="col-md-6">
                <h4>User Details</h4>

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
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product->id }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->quantity * $item->price }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                            <td><strong>{{ $order->total_price }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="fixed-bottom mb-4">
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-danger mr-4" onclick="cancelOrder()">Cancel Order</button>
                <button type="button" class="btn btn-warning mr-4" onclick="holdOrder()">Hold Order</button>
                <button type="button" class="btn btn-primary" onclick="shipOrder()">Ship Order</button>
            </div>
        </div>
    </div>

    <script>
        function cancelOrder() {
            if (confirm('Are you sure you want to cancel this order?')) {
                window.location.href = '{{ route('vendor.order.cancel', ['id' => $order->id]) }}';
            }
        }

        function holdOrder() {
            if (confirm('Are you sure you want to put this order on hold?')) {
                window.location.href = '{{ route('vendor.order.hold', ['id' => $order->id]) }}';
            }
        }

        function shipOrder() {
            if (confirm('Are you sure you want to mark this order as shipped?')) {
                window.location.href = '{{ route('vendor.order.ship', ['id' => $order->id]) }}';
            }
        }
    </script>
@endsection
