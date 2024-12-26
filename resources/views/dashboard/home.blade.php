@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
@section('title')
    {{ 'Home' }}
@endsection
@section('page-title')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('body')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="container">
                <h2>Statistics</h2>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <p class="card-text">{{ $totalOrders }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Views</h5>
                                <p class="card-text">{{ $totalViews }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Services</h5>
                                <p class="card-text">{{ $services }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sales Percentage Change</h5>
                                <p class="card-text">{{ number_format($salesPercentage, 2) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="mt-5">Orders by Device Type</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Device Type</th>
                            <th>Order Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deviceOrders as $deviceOrder)
                            <tr>
                                <td>{{ $deviceOrder->device_type }}</td>
                                <td>{{ $deviceOrder->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h2 class="mt-5">Subscribers List</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Subscription Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscribers as $index => $subscriber)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>{{ $subscriber->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h2 class="mt-5">Orders</h2>
                <table id="ordersTable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Duration</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order->service->name }}</td>
                                <td>{{ $order->subscription_duration }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->message }}</td>
                                <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h2 class="mt-5">Charts</h2>
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="ordersChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <form id="filter-form" method="GET" action="">
                            <label for="filter">Filter by:</label>
                            <select name="filter" id="filter" class="form-control">
                                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Month</option>
                                <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>Day</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
                        </form>
                        <canvas id="topServicesChart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable();

        var ctx = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($deviceOrders->pluck('device_type')),
                datasets: [{
                    label: 'Orders by Device Type',
                    data: @json($deviceOrders->pluck('total')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var topServicesCtx = document.getElementById('topServicesChart').getContext('2d');
        var topServicesChart = new Chart(topServicesCtx, {
            type: 'bar',
            data: {
                labels: @json($serviceNames),
                datasets: [{
                    label: 'Top Selling Services',
                    data: @json($topServices->pluck('total')),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
