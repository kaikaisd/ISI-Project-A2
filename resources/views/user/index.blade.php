@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>User Profile</h2>

        <div class="row">
            <div class="col-md-12">
                <h3>Recent Orders</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at }}</td>
                                @php
                                    $sum = 0;
                                    foreach ($order->orderProduct as $product) {
                                        $sum += $product->price;
                                    }
                                @endphp
                                <td>${{ $sum }}</td>
                                <td style="font-size: 1.25rem;">{{$order->status}}</td>
                                <td>
                                    <a href="{{ route('order.detail', $order->id) }}" class="btn btn-primary">
                                        <i class="fa-solid fa-eye"></i>
                                        </a>
                                            
                                            @if($order->status == 'Pending')
                                            <span>&nbsp;</span>
                                            <a href="{{ route('order.cancel', $order->id) }}" onClick="confirm('Do you want to cancel the order {{$order->id}} ?')" class="btn btn-danger"><i class="fa-solid fa-ban"></i></a>
                                            @endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br/>
            <div class="col-md-12 d-grid gap-2">
                <a href="{{ route('order.index') }}" class="btn btn-primary">View All Orders</a>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <h3>Change Password</h3>
                <form action="{{ route('user.change-password') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
