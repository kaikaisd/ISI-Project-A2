@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Order List</h1>

        <table class="table table-striped">
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (count($orders) === 0)
                    <tr>
                        <td colspan="4">No orders found.</td>
                    </tr>
                @endif
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('F j, Y') }}</td>
                        <td>
                            <button class="btn btn-primary" type="button" data-toggle="collapse"
                                data-target="#order-details-{{ $order->id }}" aria-expanded="false"
                                aria-controls="order-details-{{ $order->id }}">
                                Details
                            </button>
                            @if ($order->status === 1)
                                <form action="{{ route('order.cancel', ['id' => $order->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    <tr class="collapse" id="order-details-{{ $order->id }}">
                        <td colspan="4">
                            <div class="card card-body">
                                <ul>
                                    @foreach ($order->orderProduct as $item)
                                        <li>
                                            {{ $item->product->name }} ({{ $item->quantity }} x {{ $item->price }}) =
                                            {{ $item->total_price }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $('[data-toggle="collapse"]').each(function() {
            var target = $(this).data('target');
            var $target = $(target);
            $(this).click(function() {
                $target.collapse('toggle');
            });
        });
    </script>
@endsection
