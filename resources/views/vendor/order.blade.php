@extends('layouts.app')
@section('title', 'Order Management')


@section('content')
    <div class="container">
        <h2>Order Management</h2>
        <form action="{{ route('vendor.order.index') }}" method="GET" class="mb-4">
            <input hidden name="id" value="{{ request('id') ?? '' }}">
            <input hidden name="user" value="{{ request('user') ?? '' }}">
            <input hidden name="date" value="{{ request('date') ?? '' }}">
            <input hidden name="order" value="{{ request('order') == 'asc' ? 'desc' : 'asc' }}">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <label for="id">Order ID:</label>
                    <input type="text" name="id" id="id" class="form-control" value="{{ request('id') }}">
                </div>
                <div class="col-md-6">
                    <label for="status">Order Status: {!! request('status') === 1 !!}</label>
                    <select name="status" id="status" class="form-control">
                        <option value="" {{ request('status') == '' ? ' selected' : '' }}>All</option>
                        <option value="-1" {!! request('status') == '-1' ? ' selected' : '' !!}>Cenceled</option>
                        <option value="1" {!! request('status') == '1' ? ' selected' : '' !!}>Pending</option>
                        <option value="2" {!! request('status') == '2' ? ' selected' : '' !!}>On Hold</option>
                        <option value="3" {!! request('status') == '3' ? ' selected' : '' !!}>Delivered</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="user">User:</label>
                    <input type="text" name="user" id="user" class="form-control" value="{{ request('user') }}">
                </div>
                <div class="col-md-6">
                    <label for="created_date">Created Date:</label>
                    <div class="input-group" id="created_datepicker">
                        <input type="date" name="date" id="date" class="form-control"
                            value="{{ request('created_at') }}">
                    </div>
                </div>
                <div class="col-12">
                    <br/>
                    <button type="submit" class="btn btn-primary btn-block">Filter Orders</button>
                    &nbsp;
                    <a href="{{ route('vendor.order.index') }}" class="btn btn-secondary btn-block">Reset</a>
                </div>
            </div>
        </form>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th><a href="{{ route('vendor.order.index', ['created_date' => request('create_date') ?? '', 'user' => request('user')  ?? '', 'status' => request('status')  ?? '', 'id'=> request('id')  ?? '' ,'sort'=>'id', 'order'=>  request('order') == 'asc' ? 'desc' : 'asc']) }}">ID</a></th>
                    <th>User</th>
                    <th><a href="{{ route('vendor.order.index', ['created_date' => request('create_date') ?? '', 'user' => request('user')  ?? '', 'status' => request('status')  ?? '', 'id'=> request('id')  ?? '' ,'sort'=>'price', 'order'=>  request('order') == 'asc' ? 'desc' : 'asc']) }}">Total amount</a></th>
                    <th><a href="{{ route('vendor.order.index', ['created_date' => request('create_date') ?? '', 'user' => request('user')  ?? '', 'status' => request('status')  ?? '', 'id'=> request('id')  ?? '' ,'sort'=>'status', 'order'=>  request('order') == 'asc' ? 'desc' : 'asc']) }}">Status</a></th>
                    <th><a href="{{ route('vendor.order.index', ['created_date' => request('create_date') ?? '', 'user' => request('user')  ?? '', 'status' => request('status')  ?? '', 'id'=> request('id')  ?? '' ,'sort'=>'created_at', 'order'=>  request('order') == 'asc' ? 'desc' : 'asc']) }}">Ordered At</a></th>
                    <th><a href="{{ route('vendor.order.index', ['created_date' => request('create_date') ?? '', 'user' => request('user')  ?? '', 'status' => request('status')  ?? '', 'id'=> request('id')  ?? '' ,'sort'=>'updated_at', 'order'=>  request('order') == 'asc' ? 'desc' : 'asc']) }}">Last Updated</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (count($orders) == 0)
                    <tr>
                        <td colspan="6" class="text-center">No orders found</td>
                    </tr>
                @else
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->updated_at }}</td>
                            <td>
                                <a href="{{ route('vendor.order.detail', ['id' => $order->id]) }}"
                                    class="btn btn-primary btn-sm">Detail</a>&nbsp;
                                @if (
                                    $order->status == 'Pending' ||
                                        ($order->status == 'On Hold' && $order->status != 'Completed' && $order->status != 'Canceled'))
                                    @if ($order->status == 'Pending')
                                        <a href="{{ route('vendor.order.action', ['id' => $order->id, 'action' => 'hold']) }}"
                                            class="btn btn-warning btn-sm"
                                            onclick="alert('Do you want to hold this order?')"> Hold</a>&nbsp;
                                        <a href="{{ route('vendor.order.action', ['id' => $order->id, 'action' => 'done']) }}"
                                            class="btn btn-success btn-sm"
                                            onclick="alert('Do you want to ship this order?')"> Deliver</a>&nbsp;
                                    @endif
                                    @if ($order->status == 'On Hold')
                                        <a href="{{ route('vendor.order.action', ['id' => $order->id, 'action' => 'unhold']) }}"
                                            class="btn btn-warning btn-sm"
                                            onclick="alert('Do you want to unhold this order?')">Unhold</a>&nbsp;
                                    @endif

                                    <a href="{{ route('vendor.order.action', ['id' => $order->id, 'action' => 'cancel']) }}"
                                        class="btn btn-danger btn-sm" onclick="alert('Do you want to cancel this order?')">
                                        Cancel</a>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

@endsection
