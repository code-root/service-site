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
                        </div>
                        @endcan
                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Activation Code</th>
                                <th>Customer Name</th>
                                <th>Software Name</th>
                                <th>License Status</th>
                                <th>Purchase Date</th>
                                <th>Expiration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($licenses as $license)
                                <tr>
                                    <td>{{ $license->activation_code }}</td>
                                    <td>{{ $license->client->name }}</td>
                                    <td>{{ $license->program->name }}</td>
                                    <td>{{ $license->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>{{ $license->purchase_date }}</td>
                                    <td>{{ $license->expiry_date }}</td>
                                    <td>
                                        <a href="{{ route('license.edit', $license->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('license.destroy', $license->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this license?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('dashboard.layouts.footer')
@endsection

@section('footer-script')
<script>
$(document).ready(function() {

    // Delete license
    $(document).on('click', '.delete-licenses', function() {
        var itemId = $(this).data('id');
        var url = `{{ route('license.destroy', ':id') }}`.replace(':id', itemId);

        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to revert this action!',
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
                        Swal.fire('Deleted!', 'The license has been deleted.', 'success');
                    }
                });
            }
        });
    });
});
</script>
@endsection
