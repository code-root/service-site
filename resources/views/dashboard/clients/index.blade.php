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
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Client</span></span>
                                </a>
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

@section('footer')
@section('footer-script')
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
                render: function(data, type, row) {
                    var editUrl = `{{ route('clients.edit', ':id') }}`.replace(':id', data);
                    return `
                        <a href="${editUrl}" class="dropdown-item edit-client">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="#" class="dropdown-item delete-client" data-id="${data}">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    `;
                }
            }
        ]
    });

    $(document).on('click', '.delete-client', function() {
    var itemId = $(this).data('id');
    var url = `{{ route('clients.destroy', ':id') }}`.replace(':id', itemId);

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'DELETE', // تغيير نوع الطلب إلى DELETE
                url: url,
                data: {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'DELETE' // إضافة هذا السطر إذا كنت تستخدم طريقة POST مع DELETE
                },
                success: function(data) {
                    table.ajax.reload();
                    Swal.fire('Deleted!', 'The client has been deleted.', 'success');
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'An error occurred while deleting the client.', 'error');
                }
            });
        }
    });
});
});
</script>
@endsection
@endsection
