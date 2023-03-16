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
                @else
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('F j, Y') }}</td>
                        <td>
                            <a href="{{ route('order.detail',['id' => $order->id]) }}" class="btn btn-primary" >
                                Details
                            </a>
                            @if ($order->status === 'Pending' || $order->status === 'On Hold')
                                <form action="{{ route('order.cancel', ['id' => $order->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
