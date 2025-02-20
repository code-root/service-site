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
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">Sales Data</div>
                    <div class="card-body">
                        <table id="salesTable" class="table table-bordered table-striped table-hover">
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
      // Function to get the current month's date range
   function getCurrentMonthRange() {
            let now = new Date();
            let firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
            let lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
            let formatDate = (date) => date.toISOString().split('T')[0];
            return { start: formatDate(firstDay), end: formatDate(lastDay) };
        }

    $(document).ready(function() {
        var salesChart, salesPieChart, topSellingChart;

        // Initialize DataTable for last purchases and sales data
        $('#salesTable').DataTable({
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




        // Load sales data and render charts
        function loadSalesData(startDate, endDate) {
            $.ajax({
                url: "{{ route('sales.data') }}",
                type: 'GET',
                data: { start_date: startDate, end_date: endDate },
                success: function(response) {
                    let labels = [], data = [], totalSales = 0, totalOrders = 0;
                    let salesCategories = {};
                    let topSellingLabels = [], topSellingData = [];

                    // Process sales data
                    if (response.sales && response.sales.length > 0) {
                        response.sales.forEach(sale => {
                            labels.push(sale.date);
                            data.push(parseFloat(sale.revenue));
                            totalSales += parseFloat(sale.revenue);
                            totalOrders += parseInt(sale.sales_count);
                        });
                    }

                    // Process top selling programs data
                    if (response.top_selling_programs && response.top_selling_programs.length > 0) {
                        response.top_selling_programs.forEach(program => {
                            topSellingLabels.push(program.name);
                            topSellingData.push(program.sales_count);
                        });
                    }

                    // Process sales distribution data
                    if (response.sales_distribution) {
                        for (let date in response.sales_distribution) {
                            let sales = response.sales_distribution[date];
                            sales.forEach(sale => {
                                if (!salesCategories[date]) {
                                    salesCategories[date] = 0;
                                }
                                salesCategories[date] += parseFloat(sale.revenue);
                            });
                        }
                    }

                    // Update UI with total sales and orders
                    $('#total_sales').text(`SAR ${totalSales.toFixed(2)}`);
                    $('#total_orders').text(totalOrders);
                    populateSalesTable(response.sales);
                    // Render charts and tables
                    renderChart(labels, data);
                    renderPieChart(salesCategories);
                    renderTopSellingChart(topSellingLabels, topSellingData);
                    renderLastPurchases(response.last_purchases || []);
                },
                error: function(xhr) {
                    console.error("Error loading sales data:", xhr);
                }
            });
        }

        // Function to populate sales data into the sales table
        function populateSalesTable(sales) {
            const salesTableBody = $('#salesTable tbody');
            salesTableBody.empty(); // Clear existing data

            sales.forEach((sale, index) => {
                const row = $('<tr></tr>');

                // Order ID
                row.append(`<td>Order-${index + 1}</td>`);

                // Customer (Static for now)
                row.append(`<td>${sale.client_name}</td>`);

                // Amount (Revenue)
                row.append(`<td>${sale.revenue}</td>`);

                // Date
                row.append(`<td>${sale.date}</td>`);

                // Append the row to the table body
                salesTableBody.append(row);
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
