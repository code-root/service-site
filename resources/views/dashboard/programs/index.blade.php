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
            <span class="text-muted fw-light">Programs</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table Programs</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a href="{{ route('program.create') }}" class="send-model dt-button create-new btn btn-primary waves-effect waves-light">
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Program</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
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
            url: "{{ route('program.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'name' },
            { data: 'category' },
            { data: 'description' },
            { data: 'price' },
            { data: 'status' },
            {
                data: 'id',
                render: function(data, type, row) {
                    var editUrl = `{{ route('program.edit', ':id') }}`.replace(':id', data); // Replace :id with the actual id
                    return `
                        <a href="${editUrl}" class="dropdown-item edit-program">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="#" class="dropdown-item toggle-Update" data-id="${data}" data-update="${row.status}">
                            <i class="fa fa-toggle-${row.status == 1 ? 'on' : 'off'}"></i> ${row.status == 1 ? 'Disable' : 'Enable'}
                        </a>
                    `;
                }
            }
        ]
    });

    // Toggle status
    $(document).on('click', '.toggle-Update', function() {
        var id = $(this).data('id');
        var status = $(this).data('update');
        var url = `{{ route("program.toggleStatus", ":id") }}`.replace(':id', id);

        $.ajax({
            url: url,
            type: 'PATCH',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success,
                    showConfirmButton: false,
                    timer: 1500
                });

                // Update the icon and text
                var icon = $(`.toggle-Update[data-id="${id}"] i`);
                if (response.status == 1) {
                    icon.removeClass('mdi-toggle-switch-off').addClass('mdi-toggle-switch');
                    $(`.toggle-Update[data-id="${id}"]`).html(`<i class="mdi mdi-toggle-switch"></i> Disable`);
                } else {
                    icon.removeClass('mdi-toggle-switch').addClass('mdi-toggle-switch-off');
                    $(`.toggle-Update[data-id="${id}"]`).html(`<i class="mdi mdi-toggle-switch-off"></i> Enable`);
                }

                // Reload the DataTable
                table.ajax.reload();
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update status. Please try again.',
                });
            }
        });
    });

    // Delete program
    $(document).on('click', '.delete-program', function() {
        var itemId = $(this).data('id');
        var url = `{{ route('program.destroy', ':id') }}`.replace(':id', itemId);

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
                    type: 'DELETE',
                    url: url,
                    data: { '_token': '{{ csrf_token() }}' },
                    success: function(data) {
                        table.ajax.reload();
                        Swal.fire(
                            'Deleted!',
                            'The program has been deleted.',
                            'success'
                        );
                    }
                });
            }
        });
    });

    // عند التقديم على الفورم لتحديث البيانات
    $(document).on('submit', '#programForm', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#programModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success,
                });
                table.ajax.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update program. Please try again.',
                });
            }
        });
    });
});
</script>
@endsection
@endsection
