@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Licenses</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Licenses Data Table</h5>
                        </div>
                        @can('create-licenses')
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a href="{{ route('license.create') }}" class="send-model dt-button create-new btn btn-primary waves-effect waves-light">
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New License</span></span>
                                </a>
                            </div>
                        @endcan
                        </div>
                    </div>
                    <table id="data-xx" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Activation Code</th>
                                <th>Serial Number</th>
                                <th>Customer</th>
                                <th>Software</th>
                                <th>Status</th>
                                <th>Purchase Date</th>
                                <th>Expiration Date</th>
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

<script>
    $(document).ready(function() {
        var table = $('#data-xx').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('licenses.data') }}",
                type: 'GET'
            },
            columns: [
                { data: 'activation_code' },
                { data: 'serial_number' },
                { data: 'client_name' },
                { data: 'program_name' },
                { data: 'is_active' },
                { data: 'purchase_date' },
                { data: 'expiry_date' },
                { data: 'actions', orderable: false, searchable: false }
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json'
            }
        });

        // Delete license
        $(document).on('click', '.delete-licenses', function(e) {
            e.preventDefault();
            var itemId = $(this).data('id');
            var url = `{{ route('license.destroy', ':id') }}`.replace(':id', itemId);

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
                        data: { '_token': '{{ csrf_token() }}' },
                        success: function(data) {
                            table.ajax.reload();
                            Swal.fire('تم الحذف!', 'تم حذف الترخيص.', 'success');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
