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
            <span class="text-muted fw-light">Page</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table Page</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                            <button class="btn btn-primary" id="addNewPageBtn">Add New Page</button>

                            </div>
                        </div>
                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                            <th>ID</th>
                                            <th>Name (EN)</th>
                                            <th>Name (AR)</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pages as $page)
                                            <tr>
                                                <td>{{ $page->id }}</td>
                                                <td>{{ $page->name_en }}</td>
                                                <td>{{ $page->name_ar }}</td>
                                                <td>
                                                    <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-warning">Edit</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


        <!-- Modal for adding new page -->
        <div class="modal fade" id="addPageModal" tabindex="-1" aria-labelledby="addPageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPageModalLabel">Add New Page</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addPageForm">
                        @csrf
                            <div class="mb-3">
                                <label for="name_ar" class="form-label">Name (AR)</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar" required>
                            </div>
                            <div class="mb-3">
                                <label for="name_en" class="form-label">Name (EN)</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" required>
                            </div>
                            <div class="mb-3">
                                <label for="description_ar" class="form-label">Description (AR)</label>
                                <textarea class="form-control" id="description_ar" name="description_ar"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="description_en" class="form-label">Description (EN)</label>
                                <textarea class="form-control" id="description_en" name="description_en"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Page</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 

@section('footer')
<script>
    $(document).ready(function() {
        $('#addNewPageBtn').click(function() {
            $('#addPageModal').modal('show');
        });

        $('#addPageForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('pages.store') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addPageModal').modal('hide');
                    location.reload(); // Reload the page to see the new page
                },
                error: function(xhr) {
                    // Handle errors here
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
@endsection