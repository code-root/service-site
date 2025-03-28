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

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">Sales Data</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="salesTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Program</th>
                                        <th>Customer Name</th>
                                        <th>Customer Phone</th>
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
</div>
@endsection

@section('footer-script')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> <!-- DataTable JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> <!-- DataTable CSS -->
<!-- DataTables Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        var salesTable = $('#salesTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        // Initialize with the current month's date range
        let now = new Date();
        let firstDay = new Date(now.getFullYear(), now.getMonth(), 1).toISOString().split('T')[0];
        let lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0).toISOString().split('T')[0];
        loadSalesData(firstDay, lastDay);

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

        function loadSalesData(startDate, endDate) {
            let x = 0;

            $.ajax({
                url: '{{ route("getSalesReportData") }}',
                method: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    salesTable.clear().draw();
                    response.sales.forEach(function(sale) {
                        salesTable.row.add([
                            sale.order_id ?? x++,
                            sale.program_name,
                            sale.client_name,
                            sale.client_phone,
                            sale.revenue,
                            sale.date
                        ]).draw(false);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching sales data:', error);
                }
            });
        }
    });
</script>
@endsection
