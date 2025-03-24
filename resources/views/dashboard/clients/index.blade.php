@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Clients</span>
        </h4>

        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table Clients</h5>
                        </div>
                        @can('create-clients')
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a href="{{ route('clients.create') }}" class="send-model dt-button create-new btn btn-primary waves-effect waves-light">
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Client</span></span></a>
                                <button id="exportExcel" class="btn btn-success">Export to Excel</button>
                            </div>
                        </div>
                        @endcan
                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<!-- Include DataTables Buttons CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#data-x').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('clients.data') }}",
                type: 'GET'
            },
            columns: [
                { data: 'name' },
                { data: 'location' },
                { data: 'phone' },
                { data: 'email' },
                {
                    data: 'id',
                    @can('write-clients')
                    render: function(data, type, row) {
                        var editUrl = `{{ route('clients.edit', ':id') }}`.replace(':id', data);
                        return `
                            <a href="${editUrl}" class="dropdown-item ">
                                <i class="fa fa-pencil"></i> تعديل
                            </a>
                            <a href="#" class="dropdown-item delete-client" data-id="${data}">
                                <i class="fa fa-trash"></i> حذف
                            </a>
                        `;
                    }
                    @endcan
                }
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json'
            }
        });

        $(document).on('click', '.delete-client', function() {
            var itemId = $(this).data('id');
            var url = `{{ route('clients.destroy', ':id') }}`.replace(':id', itemId);

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'لن تتمكن من التراجع عن هذا!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذفه!',
                cancelButtonText: 'لا، إلغاء!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {
                            '_token': '{{ csrf_token() }}',
                            '_method': 'DELETE'
                        },
                        success: function(data) {
                            table.ajax.reload();
                            Swal.fire('تم الحذف!', 'تم حذف العميل.', 'success');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('خطأ!', 'حدث خطأ أثناء حذف العميل.', 'error');
                        }
                    });
                }
            });
        });

        $('#exportExcel').on('click', function() {
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet('العملاء');

            worksheet.columns = [
                { header: 'الاسم', key: 'name', width: 30 },
                { header: 'الموقع', key: 'location', width: 30 },
                { header: 'الهاتف', key: 'phone', width: 20 },
                { header: 'البريد الإلكتروني', key: 'email', width: 30 }
            ];

            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                worksheet.addRow({
                    name: data.name,
                    location: data.location,
                    phone: data.phone,
                    email: data.email
                });
            });

            workbook.xlsx.writeBuffer().then(function(buffer) {
                var blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'العملاء.xlsx';
                link.click();
            });
        });
    });
    </script>
@endsection
