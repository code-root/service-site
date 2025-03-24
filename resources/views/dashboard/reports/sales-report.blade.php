@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')
<style>
    /* Custom Styles */
    .card {
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .card-header {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa !important;
    }

    .badge {
        font-weight: 500;
        padding: 5px 10px;
    }

    .btn {
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 10px;
        margin-left: 5px;
        border-radius: 5px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #0d6efd !important;
        color: white !important;
        border: 1px solid #0d6efd;
    }

    @media (max-width: 768px) {
        .card-body canvas {
            height: 250px !important;
        }
    }
</style>
<div class="content-wrapper" style="background-color: #f8f9fa;">
    <div class="container-xxl animate__animated animate__fadeIn py-4">
        <!-- Success or Error Alerts -->
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Page Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold"><i class="fas fa-chart-line me-2"></i>Sales Report</h2>
            <div class="bg-primary p-2 rounded">
                <span class="text-white" id="current-date-range"></span>
            </div>
        </div>

        <!-- Date Range Picker and Filter Button -->
        <div class="card shadow-sm mb-4 border-primary">
            <div class="card-header bg-primary text-white py-3">
                <i class="fas fa-calendar-alt me-2"></i>Filter by Date
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date:</label>
                        <input type="date" id="start_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date:</label>
                        <input type="date" id="end_date" class="form-control">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100" id="filter">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-outline-secondary w-100" id="reset">
                            <i class="fas fa-sync-alt me-2"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Sales and Orders -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-success h-100">
                    <div class="card-header bg-success text-white py-3">
                        <i class="fas fa-dollar-sign me-2"></i>Total Sales
                    </div>
                    <div class="card-body text-center py-4">
                        <h2 id="total_sales" class="text-success fw-bold">0.00 SAR</h2>
                        <p class="text-muted mb-0">Total sales value during the selected period</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-primary h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <i class="fas fa-shopping-cart me-2"></i>Total Orders
                    </div>
                    <div class="card-body text-center py-4">
                        <h2 id="total_orders" class="text-primary fw-bold">0</h2>
                        <p class="text-muted mb-0">Number of completed orders during the selected period</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <!-- Top Selling Programs -->
            <div class="col-md-6">
                <div class="card shadow-sm border-danger h-100">
                    <div class="card-header bg-danger text-white py-3">
                        <i class="fas fa-star me-2"></i>Top Selling Programs
                    </div>
                    <div class="card-body" style="height: 300px;">
                        <canvas id="topSellingChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Sales Distribution -->
            <div class="col-md-6">
                <div class="card shadow-sm border-info h-100">
                    <div class="card-header bg-info text-white py-3">
                        <i class="fas fa-chart-pie me-2"></i>Sales Distribution
                    </div>
                    <div class="card-body" style="height: 300px;">
                        <canvas id="salesPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Last Purchases Table -->
        <div class="card shadow-sm border-secondary mb-4">
            <div class="card-header bg-secondary text-white py-3">
                <i class="fas fa-history me-2"></i>Last 5 Purchases
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="lastPurchasesTable" class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Activation Code</th>
                                <th width="10%">Client</th>
                                <th width="15%">Program</th>
                                <th width="10%">Price</th>
                                <th width="10%">Purchase Date</th>
                                <th width="10%">Expiry Date</th>
                                <th width="10%">Status</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sales Trend Chart -->
        <div class="card shadow-sm border-warning">
            <div class="card-header bg-warning text-white py-3">
                <i class="fas fa-chart-area me-2"></i>Sales Trend
            </div>
            <div class="card-body" style="height: 350px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<!-- Required Libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
    // Global chart variables
    let salesChart, salesPieChart, topSellingChart;
    let dataTable;

    // Format date to DD/MM/YYYY
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('ar-EG');
    }

    // Format currency
    function formatCurrency(amount) {
        return parseFloat(amount || 0).toFixed(2) + ' SAR';
    }

    // Load sales data and render charts
    function loadSalesData(startDate, endDate) {
        $.ajax({
            url: "{{ route('sales.data') }}",
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            beforeSend: function() {
                // Show loading indicators
                $('#total_sales').html('<i class="fas fa-spinner fa-spin"></i>');
                $('#total_orders').html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                let totalSales = 0, totalOrders = 0;

                // Process sales data
                if (response.sales && response.sales.length > 0) {
                    response.sales.forEach((sale) => {
                        totalSales += parseFloat(sale.revenue);
                        totalOrders += parseInt(sale.sales_count);
                    });
                }

                // Update UI with total sales and orders
                $('#total_sales').text(formatCurrency(totalSales));
                $('#total_orders').text(totalOrders.toLocaleString('ar-EG'));

                // Update date range display
                const startFormatted = formatDate(startDate);
                const endFormatted = formatDate(endDate);
                $('#current-date-range').text(`الفترة من ${startFormatted} إلى ${endFormatted}`);

                // Render charts if data exists
                if (response.chart_data) {
                    renderChart(response.chart_data.labels, response.chart_data.data);
                }

                if (response.pie_data) {
                    renderPieChart(response.pie_data.labels, response.pie_data.data);
                }

                if (response.top_selling) {
                    renderTopSellingChart(
                        response.top_selling.labels,
                        response.top_selling.data
                    );
                }

                // Load last purchases
                loadLastPurchases(startDate, endDate);
            },
            error: function(xhr) {
                console.error("Error loading sales data:", xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء جلب بيانات المبيعات'
                });
            }
        });
    }

    // Load last purchases
    function loadLastPurchases(startDate, endDate) {
        $.ajax({
            url: "{{ route('sales.data') }}",
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
                limit: 5
            },
            success: function(response) {
                if ( response.last_purchases) {
                    renderLastPurchases(response.last_purchases);
                }
            },
            error: function(xhr) {
                console.error("Error loading last purchases:", xhr);
            }
        });
    }

    // Render last purchases table
    function renderLastPurchases(purchases) {
        const tableBody = $('#lastPurchasesTable tbody');
        tableBody.empty();

        if (purchases.length === 0) {
            tableBody.append(`
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="fas fa-info-circle me-2"></i>لا توجد بيانات متاحة
                    </td>
                </tr>
            `);
            return;
        }

        purchases.forEach((purchase, index) => {
            const client = purchase.client || {};
            const program = purchase.program || {};

            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        <span class="badge bg-primary">${purchase.activation_code || 'N/A'}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <h6 class="mb-0">${client.name || 'N/A'}</h6>
                                <small class="text-muted">${client.email || ''}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <h6 class="mb-0">${program.name || 'N/A'}</h6>
                        <small class="text-muted">${program.description ? program.description.substring(0, 30) + '...' : ''}</small>
                    </td>
                    <td class="text-success fw-bold">${program.price ? formatCurrency(program.price) : 'N/A'}</td>
                    <td>${formatDate(purchase.purchase_date)}</td>
                    <td>${formatDate(purchase.expiry_date)}</td>
                    <td>
                        <span class="badge ${purchase.is_active ? 'bg-success' : 'bg-secondary'}">
                            ${purchase.is_active ? 'نشط' : 'منتهي'}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary view-details" data-id="${purchase.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            `;
            tableBody.append(row);
        });

        // Initialize or reinitialize DataTable
        if (dataTable) {
            dataTable.destroy();
        }

        dataTable = $('#lastPurchasesTable').DataTable({
            dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>><"clear">',
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json',
                search: "_INPUT_",
                searchPlaceholder: "بحث...",
            },
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel me-2"></i>تصدير Excel',
                    className: 'btn btn-success',
                    title: 'آخر المشتريات',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print me-2"></i>طباعة',
                    className: 'btn btn-info',
                    title: 'آخر المشتريات',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }
            ],
            responsive: true,
            order: [[5, 'desc']]
        });
    }

    // Render sales trend chart
    function renderChart(labels, data) {
        const ctx = document.getElementById('salesChart').getContext('2d');
        if (salesChart) salesChart.destroy();

        salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'قيمة المبيعات',
                    data: data,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffc107',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Tajawal',
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return formatCurrency(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return formatCurrency(value);
                            }
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Render sales distribution pie chart
    function renderPieChart(labels, data) {
        const ctx = document.getElementById('salesPieChart').getContext('2d');
        if (salesPieChart) salesPieChart.destroy();

        const backgroundColors = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)'
        ];

        salesPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        rtl: true,
                        labels: {
                            font: {
                                family: 'Tajawal',
                                size: 12
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${formatCurrency(value)} (${percentage}%)`;
                            }
                        }
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            const total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return percentage > 5 ? `${percentage}%` : '';
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 12
                        }
                    }
                },
                cutout: '70%',
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    // Render top selling programs chart
    function renderTopSellingChart(labels, data) {
        const ctx = document.getElementById('topSellingChart').getContext('2d');
        if (topSellingChart) topSellingChart.destroy();

        topSellingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'عدد المبيعات',
                    data: data,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} عملية بيع`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                animation: {
                    duration: 2000
                }
            }
        });
    }

    // Get current month date range
    function getCurrentMonthRange() {
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

        const formatDate = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        return {
            start: formatDate(firstDay),
            end: formatDate(lastDay)
        };
    }

    // Initialize page
    $(document).ready(function() {
        // Set default dates (current month)
        const dateRange = getCurrentMonthRange();
        $('#start_date').val(dateRange.start);
        $('#end_date').val(dateRange.end);

        // Load initial data
        loadSalesData(dateRange.start, dateRange.end);

        // Filter button click handler
        $('#filter').click(function() {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();

            if (startDate && endDate) {
                if (new Date(startDate) > new Date(endDate)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في التاريخ',
                        text: 'تاريخ البداية يجب أن يكون قبل تاريخ النهاية'
                    });
                    return;
                }
                loadSalesData(startDate, endDate);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'بيانات ناقصة',
                    text: 'الرجاء تحديد تاريخ البداية والنهاية'
                });
            }
        });

        // Reset button click handler
        $('#reset').click(function() {
            const dateRange = getCurrentMonthRange();
            $('#start_date').val(dateRange.start);
            $('#end_date').val(dateRange.end);
            loadSalesData(dateRange.start, dateRange.end);
        });

        // View details button handler (delegated event)
        $('#lastPurchasesTable').on('click', '.view-details', function() {
            const purchaseId = $(this).data('id');
            // Implement your details view logic here
            Swal.fire({
                title: 'تفاصيل الشراء',
                text: `عرض التفاصيل للشراء رقم ${purchaseId}`,
                icon: 'info',
                confirmButtonText: 'موافق'
            });
        });
    });
</script>

@endsection
