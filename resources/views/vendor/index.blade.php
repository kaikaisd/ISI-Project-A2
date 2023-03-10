@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Vendor Dashboard</h2>

        <div class="row">
            <div class="col-md-6">
                <canvas id="sales-chart"></canvas>
            </div>
            <div class="col-md-6">
                <h4>Order Summary:</h4>
                <ul>
                    <li><a href="{{ route('vendor.order.index', ['status' => 'new']) }}">New Orders:
                            {{ $orderStatus['new'] }}</a></li>
                    <li><a href="{{ route('vendor.order.index', ['status' => 'processing']) }}">Processing Orders:
                            {{ $orderStatus['processing'] }}</a></li>
                    <li><a href="{{ route('vendor.order.index', ['status' => 'completed']) }}">Completed Orders:
                            {{ $orderStatus['completed'] }}</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('vendor.product.index') }}" class="btn btn-primary">Manage Products</a>
            <a href="{{ route('vendor.order.index') }}" class="btn btn-primary ml-2">Manage Orders</a>
        </div>
    </div>

    <script>
        // Chart.js code for sales chart
        var ctx = document.getElementById('sales-chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: {!! json_encode($topProducts->pluck('name')) !!},
                datasets: [{
                    label: 'Sales Volume',
                    data: {!! json_encode($topProducts->pluck('sales_volume')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection
