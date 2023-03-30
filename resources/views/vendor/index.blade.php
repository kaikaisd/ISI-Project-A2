@extends('layouts.app')
@section('title', 'Vendor Dashboard')

@section('content')
    <div class="container">
        <h2>Vendor Dashboard</h2>

        <div class="row">
            <div class="col-md-6">
                <h4>Top 5 Products:</h4>
                <div class=""><canvas id="schart" width="400" height="250"></canvas></div>
            </div>
            <div class="col-md-6">
                <div class=""><canvas id="smchart" width="400" height="200"></canvas></div>
            </div>
            <div class="col-md-12 d-flex justify-content-center ">
                <form method="GET" class="">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}">&nbsp;
                    <label for="end_date">End Date:</label>

                    <input type="date" name="end_date" value="{{ request('end_date') }}">&nbsp;
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            <br/>
            <div class="col-md-12">
                <h4>Order Summary:</h4>
                <ul>
                    <li><a href="{{ route('vendor.order.index', ['status' => '1']) }}">New Orders:
                            {{ $newOrders }}</a></li>
                    <li><a href="{{ route('vendor.order.index', ['status' => '2']) }}">Processing Orders:
                            {{ $processingOrders }}</a></li>
                    <li><a href="{{ route('vendor.order.index', ['status' => '3']) }}">Completed Orders:
                            {{ $completedOrders }}</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center ">
            <a href="{{ route('vendor.product.index') }}" class="btn btn-primary btn-lg">Manage Products</a>
            &nbsp;
            <a href="{{ route('vendor.order.index') }}" class="btn btn-primary ml-2 btn-lg">Manage Orders</a>
            &nbsp;
            <a href="{{ route('vendor.cad.index') }}" class="btn btn-primary ml-2 btn-lg">Manage Categories & Brands</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <script type="module" type="text/javascript">
    var ctx = document.getElementById('schart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! $topProductsLabel !!},
            datasets: [{
                label: 'Sales Volume',
                data: {!! $topProductsData !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        }
    });
    var stx = document.getElementById('smchart').getContext('2d');
    var chart2 = new Chart(stx, {
        type: 'bar',
        data: {
            labels: {!! $topProductsLabel !!},
            datasets: [{
                label: 'Sales Amount',
                data: {!! $topProductsAmount !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        }
    });
</script>
@endsection
