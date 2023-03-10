@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Order Management</h2>

        <form action="{{ route('vendor.order.index') }}" method="GET" class="mb-4">
            <div class="form-row align-items-center">
                <div class="col-md-2">
                    <label for="id">Order ID:</label>
                    <input type="text" name="id" id="id" class="form-control" value="{{ request('id') }}">
                </div>
                <div class="col-md-2">
                    <label for="status">Order Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}"{{ request('status') === $status ? ' selected' : '' }}>
                                {{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="user">User:</label>
                    <input type="text" name="user" id="user" class="form-control" value="{{ request('user') }}">
                </div>
                <div class="col-md-3">
                    <label for="created_date">Created Date:</label>
                    <div class="input-group">
                        <input type="text" name="created_date" id="created_date" class="form-control"
                            value="{{ request('created_date') }}">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">Filter Orders</button>
                </div>
            </div>
        </form>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Ordered At</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>
                            <a href="{{ route('vendor.order.show', ['id' => $order->id]) }}"
                                class="btn btn-primary btn-sm">Detail</a>
                            <form action="{{ route('vendor.order.destroy', ['id' => $order->id]) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
@endsection
