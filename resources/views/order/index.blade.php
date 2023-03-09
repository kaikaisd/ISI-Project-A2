@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Orders</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>
                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => $sort == 'id' && $order == 'asc' ? 'desc' : 'asc']) }}">
                            Order ID
                            @if ($sort == 'id')
                                @if ($order == 'asc')
                                    <i class="fa fa-sort-asc"></i>
                                @else
                                    <i class="fa fa-sort-desc"></i>
                                @endif
                            @else
                                <i class="fa fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => $sort == 'status' && $order == 'asc' ? 'desc' : 'asc']) }}">
                            Status
                            @if ($sort == 'status')
                                @if ($order == 'asc')
                                    <i class="fa fa-sort-asc"></i>
                                @else
                                    <i class="fa fa-sort-desc"></i>
                                @endif
                            @else
                                <i class="fa fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => $sort == 'created_at' && $order == 'asc' ? 'desc' : 'asc']) }}">
                            Ordered Date
                            @if ($sort == 'created_at')
                                @if ($order == 'asc')
                                    <i class="fa fa-sort-asc"></i>
                                @else
                                    <i class="fa fa-sort-desc"></i>
                                @endif
                            @else
                                <i class="fa fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => 'updated_at', 'order' => $sort == 'updated_at' && $order == 'asc' ? 'desc' : 'asc']) }}">
                            Last Update Date
                            @if ($sort == 'updated_at')
                                @if ($order == 'asc')
                                    <i class="fa fa-sort-asc"></i>
                                @else
                                    <i class="fa fa-sort-desc"></i>
                                @endif
                            @else
                                <i class="fa fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>
                            <a href="{{ route('order.show', ['id' => $order->id]) }}" class="btn btn-primary">View
                                Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
