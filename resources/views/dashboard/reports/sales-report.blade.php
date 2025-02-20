@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<div class="content-wrapper">
    <div class="container-xxl animate__animated animate__fadeIn">

        <!-- Success or Error Alerts -->
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ $message }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Page Heading -->
        <h4 class="py-3 mb-4 text-center text-primary">Sales Reports</h4>

        <!-- Date Range Picker and Filter Button -->
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="start_date">Select Date Range:</label>
                <input type="date" id="start_date" class="form-control">
                <input type="date" id="end_date" class="form-control mt-2">
            </div>
            <div class="col-md-4 align-self-end">
                <button class="btn btn-primary" id="filter"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </div>

        <!-- Total Sales and Orders -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">Total Sales</div>
                    <div class="card-body text-center">
                        <h3 id="total_sales"><i class="fas fa-dollar-sign"></i> 0.00 SAR </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">Total Orders</div>
                    <div class="card-body text-center">
                        <h3 id="total_orders"><i class="fas fa-box"></i> 0</h3>
                    </div>
                </div>
            </div>
        </div>



        <!-- Top Selling Programs -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-danger text-white">Top Selling Programs</div>
            <div class="card-body" style="height: 250px;">
                <canvas id="topSellingChart"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">Last 5 Purchases</div>
                    <div class="card-body">
                        <table id="lastPurchasesTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- الرسوم البيانية جنبًا إلى جنب وبحجم أصغر -->
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-warning text-white">Sales Overview</div>
                    <div class="card-body" style="height: 250px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white">Sales Distribution</div>
                    <div class="card-body" style="height: 250px;">
                        <canvas id="salesPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script> <!-- Animate.css -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> <!-- DataTable JS -->
<script src="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script> <!-- DataTable CSS -->
<!-- DataTables Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        var salesChart, salesPieChart, topSellingChart;


    $('#lastPurchasesTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger',
                title: 'Sales Report'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success',
                title: 'Sales Report'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-primary',
                title: 'Sales Report'
            },
            {
                extend: 'copyHtml5',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-secondary'
            }
        ]
    });

        // Function to get the current month's date range
        function getCurrentMonthRange() {
            let now = new Date();
            let firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
            let lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
            let formatDate = (date) => date.toISOString().split('T')[0];
            return { start: formatDate(firstDay), end: formatDate(lastDay) };
        }




        // Render sales overview chart
        function renderChart(labels, data) {
            let ctx = document.getElementById('salesChart').getContext('2d');
            if (salesChart) salesChart.destroy();
            salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales Revenue',
                        data: data,
                        borderColor: 'blue',
                        borderWidth: 2,
                        fill: true,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)'
                    }]
                },
                options: { animation: { duration: 1500 } }
            });
        }

        // Render sales distribution pie chart
        function renderPieChart(salesCategories) {
            let ctx = document.getElementById('salesPieChart').getContext('2d');
            if (salesPieChart) salesPieChart.destroy();
            salesPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(salesCategories),
                    datasets: [{
                        data: Object.values(salesCategories),
                        backgroundColor: ['#ffcc00', '#ff6600', '#ff0000', '#cc0000', '#990000'],
                    }]
                },
                options: { animation: { duration: 1500 } }
            });
        }

        // Render top selling programs chart
        function renderTopSellingChart(labels, data) {
            let ctx = document.getElementById('topSellingChart').getContext('2d');
            if (topSellingChart) topSellingChart.destroy();
            topSellingChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales Count',
                        data: data,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: { animation: { duration: 2500 } }
            });
        }


        // Render last 5 purchases
        function renderLastPurchases(purchases) {
            const purchasesTableBody = $('#lastPurchasesTable tbody');
            purchasesTableBody.empty(); // Clear existing data

            purchases.forEach(purchase => {
                const row = $('<tr></tr>');
                row.append(`<td>${purchase.id}</td>`);
                row.append(`<td>${purchase.client.name}</td>`);
                row.append(`<td>${purchase.program.price}</td>`);
                row.append(`<td>${purchase.purchase_date}</td>`);
                purchasesTableBody.append(row);
            });
        }

        // Initialize with the current month's date range
        let dateRange = getCurrentMonthRange();
        loadSalesData(dateRange.start, dateRange.end);

        // On filter button click, reload the data with the selected date range
        $('#filter').click(function() {
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            if (startDate && endDate) {
                loadSalesData(startDate, endDate);
            } else {
                alert('Please select both start and end dates.');
            }
        });
    });
</script>
@endsection
