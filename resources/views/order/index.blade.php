@extends('layouts.app')
@section('title', 'Order List')
@section('content')
    <div class="container">
        <h1>Order List</h1>
        <div class="row">
            <div class="col-md-6">
                <h3>Current Purchases</h3>
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ route('order.index', ['sort' => 'id']) }}">
                                    ID
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('order.index', ['sort' => 'status']) }}">
                                    Status
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('order.index', ['sort' => 'created_at']) }}">
                                    Created Date
                                </a>
                            </th>
                            <th>
                                Total
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($activeOrders->count() == 0)
                            <tr>
                                <td colspan="5">No orders found.</td>
                            </tr>
                        @else
                            @foreach ($activeOrders as $order)
                                @if ($order->status === 'Pending' || $order->status === 'On Hold')
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        @php
                                            $sum = 0;
                                            foreach ($order->orderProduct as $product) {
                                                $sum += $product->price;
                                            }
                                        @endphp
                                        <td>${{ $sum }}</td>
                                        <td>
                                            <a href="{{ route('order.detail', ['id' => $order->id]) }}"
                                                class="btn btn-primary">
                                                Details
                                            </a>
                                            @if ($order->status === 'Pending' || $order->status === 'On Hold')
                                                <form action="{{ route('order.cancel', ['id' => $order->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-danger" type="submit">Cancel</button>
                                                </form>
                                            @endif
                                            @if ($order->status == 'Delivered')
                                                <form action="{{ route('order.review', ['id' => $order->id]) }}"
                                                    method="GET" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-success" type="submit">Review</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h3>Past Purchases</h3>

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ route('order.index', ['sort' => 'id']) }}">
                                    ID
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('order.index', ['sort' => 'status']) }}">
                                    Status
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('order.index', ['sort' => 'created_at']) }}">
                                    Created Date
                                </a>
                            </th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($inactiveOrders->count() == 0)
                            <tr>
                                <td colspan="5">No orders found.</td>
                            </tr>
                        @else
                            @foreach ($inactiveOrders as $order)
                                @if ($order->status != 'Pending' && $order->status != 'On Hold')
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        @php
                                            $sum = 0;
                                            foreach ($order->orderProduct as $product) {
                                                $sum += $product->price;
                                            }
                                        @endphp
                                        <td>${{ $sum }}</td>
                                        <td>
                                            <a href="{{ route('order.detail', ['id' => $order->id]) }}"
                                                class="btn btn-primary">
                                                Details
                                            </a>
                                            @if ($order->status === 'Pending' || $order->status === 'On Hold')
                                                <form action="{{ route('order.cancel', ['id' => $order->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-danger" type="submit">Cancel</button>
                                                </form>
                                            @endif
                                            @if ($order->status == 'Delivered')
                                                <form action="{{ route('order.review', ['id' => $order->id]) }}"
                                                    method="GET" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-success" type="submit">Review</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
