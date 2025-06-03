@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Success/Error Messages -->
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any()))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Clients /</span> Management
            </h4>
            @can('create-clients'))
            <div class="btn-group">
                <a href="{{ route('clients.create') }}" class="btn btn-primary waves-effect waves-light">
                    <i class="mdi mdi-plus me-1"></i> Add New Client
                </a>
                <button id="exportExcel" class="btn btn-success ms-2">
                    <i class="mdi mdi-file-excel me-1"></i> Export Excel
                </button>
            </div>
            @endcan
        </div>

        <!-- Clients Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Clients List</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table id="clients-table" class="table border-top table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th width="120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<!-- DataTables Resources -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#clients-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('clients.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'location', name: 'location' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { 
                data: 'id', 
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var editUrl = `{{ route('clients.edit', ':id') }}`.replace(':id', data);
                    var deleteBtn = '';
                    
                    @can('write-clients')
                    deleteBtn = `
                        <button class="btn btn-sm btn-icon btn-danger delete-client" data-id="${data}">
                            <i class="mdi mdi-delete-outline"></i>
                        </button>
                    `;
                    @endcan
                    
                    return `
                        <div class="d-flex gap-2">
                            @can('write-clients')
                            <a href="${editUrl}" class="btn btn-sm btn-icon btn-primary">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            ${deleteBtn}
                            @endcan
                        </div>
                    `;
                }
            }
        ],
        dom: '<"row mx-1"<"col-md-2"l><"col-md-6"B><"col-md-4"f>>rtip',
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-sm btn-secondary',
                text: '<i class="mdi mdi-content-copy"></i> Copy'
            },
            {
                extend: 'csv',
                className: 'btn btn-sm btn-info',
                text: '<i class="mdi mdi-file-delimited"></i> CSV'
            },
            {
                extend: 'excel',
                className: 'btn btn-sm btn-success',
                text: '<i class="mdi mdi-file-excel"></i> Excel'
            },
            {
                extend: 'pdf',
                className: 'btn btn-sm btn-danger',
                text: '<i class="mdi mdi-file-pdf"></i> PDF'
            },
            {
                extend: 'print',
                className: 'btn btn-sm btn-warning',
                text: '<i class="mdi mdi-printer"></i> Print'
            },
            {
                extend: 'colvis',
                className: 'btn btn-sm btn-dark',
                text: '<i class="mdi mdi-eye"></i> Columns'
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
        },
        responsive: true,
        drawCallback: function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    // Delete Client Confirmation
    $(document).on('click', '.delete-client', function() {
        var itemId = $(this).data('id');
        var url = `{{ route('clients.destroy', ':id') }}`.replace(':id', itemId);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        '_method': 'DELETE'
                    },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'Something went wrong',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        });
    });

    // Export to Excel with ExcelJS
    $('#exportExcel').on('click', function() {
        // Show loading indicator
        Swal.fire({
            title: 'Generating Excel File',
            html: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Get all data (not just current page)
        $.ajax({
            url: "{{ route('clients.data') }}",
            type: 'GET',
            data: { length: -1 }, // Get all records
            success: function(response) {
                // Create workbook
                var workbook = new ExcelJS.Workbook();
                var worksheet = workbook.addWorksheet('Clients');
                
                // Add headers
                worksheet.columns = [
                    { header: 'Name', key: 'name', width: 30 },
                    { header: 'Location', key: 'location', width: 25 },
                    { header: 'Phone', key: 'phone', width: 20 },
                    { header: 'Email', key: 'email', width: 30 }
                ];
                
                // Style headers
                worksheet.getRow(1).eachCell((cell) => {
                    cell.font = { bold: true };
                    cell.fill = {
                        type: 'pattern',
                        pattern: 'solid',
                        fgColor: { argb: 'FFD9D9D9' }
                    };
                });
                
                // Add data
                response.data.forEach(function(client) {
                    worksheet.addRow({
                        name: client.name,
                        location: client.location,
                        phone: client.phone,
                        email: client.email
                    });
                });
                
                // Generate file
                workbook.xlsx.writeBuffer().then(function(buffer) {
                    var blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'Clients_' + new Date().toISOString().slice(0, 10) + '.xlsx';
                    link.click();
                    
                    Swal.close();
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to generate Excel file',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });
});
</script>
@endsection