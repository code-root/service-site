@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Testimonials</span>
        </h4>

        <button class="btn btn-primary mb-3" data-bs-toggle="offcanvas" data-bs-target="#add-new-record">Add New Testimonial</button>

        <table id="data-x" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Testimonial</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Add New Testimonial</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="add-testimonial-form" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" id="position" name="position" required>
            </div>
            <div class="mb-3">
                <label for="testimonial" class="form-label">Testimonial</label>
                <textarea class="form-control" id="testimonial" name="testimonial" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Testimonial</button>
        </form>
    </div>
</div>

<!-- Modal to edit record -->
<div class="offcanvas offcanvas-end" id="edit-record">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Edit Testimonial</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="edit-testimonial-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="edit_id" name="id">
            <div class="mb-3">
                <label for="edit_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="edit_name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="edit_position" class="form-label">Position</label>
                <input type="text" class="form-control" id="edit_position" name="position" required>
            </div>
            <div class="mb-3">
                <label for="edit_testimonial" class="form-label">Testimonial</label>
                <textarea class="form-control" id="edit_testimonial" name="testimonial" required></textarea>
            </div>
            <div class="mb-3">
                <label for="edit_image" class="form-label">Image</label>
                <input type="file" class="form-control" id="edit_image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Update Testimonial</button>
        </form>
    </div>
</div>

@section('footer')
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/app-assets/vendors/js/extensions/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#data-x').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('testimonials.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'name' },
            { data: 'position' },
            { data: 'testimonial' },
            {
                data: 'image',
                render: function(data, type, row) {
                    return `<img src="{{ asset('storage/') }}/${data}" alt="Image" width="50">`;
                }
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <a href="#" class="dropdown-item edit-testimonial" data-id="${data}" data-bs-toggle="offcanvas" data-bs-target="#edit-record">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="#" class="dropdown-item delete-testimonial" data-id="${data}">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    `;
                }
            }
        ]
    });

    // Add Testimonial
    $('#add-testimonial-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('testimonials.store') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#add-new-record').offcanvas('hide');
                table.ajax.reload();
                swal("Success", response.success, "success");
            },
            error: function(response) {
                swal("Error", "There was an error adding the testimonial.", "error");
            }
        });
    });

    // Edit Testimonial
    $(document).on('click', '.edit-testimonial', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('testimonials.edit', '') }}/" + id,
            method: 'GET',
            success: function(response) {
                $('#edit_id').val(response.id);
                $('#edit_name').val(response.name);
                $('#edit_position').val(response.position);
                $('#edit_testimonial').val(response.testimonial);
            },
            error: function(response) {
                swal("Error", "There was an error fetching the testimonial data.", "error");
            }
        });
    });

    // Update Testimonial
    $('#edit-testimonial-form').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_id').val();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('testimonials.update', '') }}/" + id,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#edit-record').offcanvas('hide');
                table.ajax.reload();
                swal("Success", response.success, "success");
            },
            error: function(response) {
                swal("Error", "There was an error updating the testimonial.", "error");
            }
        });
    });

    // Delete Testimonial
    $(document).on('click', '.delete-testimonial', function() {
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this testimonial!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('testimonials.delete', '') }}/" + id,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        table.ajax.reload();
                        swal("Success", response.success, "success");
                    },
                    error: function(response) {
                        swal("Error", "There was an error deleting the testimonial.", "error");
                    }
                });
            }
        });
    });
});
</script>
@endsection
@endsection
