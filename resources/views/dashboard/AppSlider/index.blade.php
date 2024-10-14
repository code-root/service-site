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
            <span class="text-muted fw-light">AppSlider</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table AppSlider</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a class="send-model dt-button create-new btn btn-primary waves-effect waves-light" tabindex="0" type="button" data-bs-toggle="offcanvas" data-bs-target="#add-new-record">
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New App Slider</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name (Arabic)</th>
                                <th>Name (English)</th>
                                <th>Details</th>
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

<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end " id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">New AppSlider</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <div id="error-messages"></div>
        
        {{ Form::open(['route' => ['appSlider.create'],'id'=>'store-form' , 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        
        <!-- حقل الاسم باللغة العربية -->
        {{ Form::label('name_ar', 'Name AR') }}
        {{ Form::text('name_ar', null, ['class' => 'form-control']) }}
        
        <!-- حقل الاسم باللغة الإنجليزية -->
        {{ Form::label('name_en', 'Name EN') }}
        {{ Form::text('name_en', null, ['class' => 'form-control']) }}
        
        <!-- حقل الصورة -->
        {{ Form::label('image', 'Image') }}
        {{ Form::file('image', ['id' => 'image', 'name' => 'image', 'class' => 'form-control']) }}
        
        <!-- حقل التفاصيل -->
        {{ Form::label('details', 'Details') }}
        {{ Form::textarea('details', null, ['class' => 'form-control']) }}
        
        <!-- حقل الحالة -->
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', ['1' => 'active', '0' => 'not active'], null, ['class' => 'form-control']) }}

        <br>
        <br>
        <!-- زر الإرسال -->
        <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
        <!-- حقل CSRF -->
        @csrf
        {{ Form::close() }}
    </div>
</div>

<!-- Modal for delete confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                هل أنت متأكد أنك تريد حذف هذا العنصر؟
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing slider -->
<div class="modal fade" id="editSliderModal" tabindex="-1" aria-labelledby="editSliderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSliderModalLabel">تعديل السلايدر</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSliderForm">
                    <input type="hidden" id="sliderId" name="id">
                    <div class="mb-3">
                        <label for="name_ar" class="form-label">الاسم بالعربية</label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" required>
                    </div>
                    <div class="mb-3">
                        <label for="name_en" class="form-label">الاسم بالإنجليزية</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" required>
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">التفاصيل</label>
                        <textarea class="form-control" id="details" name="details"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">نشط</option>
                            <option value="0">غير نشط</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">الصورة</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <img id="currentImage" src="" alt="Current Image" class="img-thumbnail mt-2" style="max-width: 100px;">
                    </div>
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="{{ asset('assets') }}/dashboard/app-assets/vendors/js/extensions/sweetalert.min.js'"></script>
<script src="{{ asset('assets') }}/dashboard/js/app.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#data-x').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('appSlider.data') }}",
            type: 'GET'
        },
        columns: [
            {
                data: 'image',
                render: function(data, type, row) {
                    var imgSrc = data ? 'public/storage/' + data : 'https://ui-avatars.com/api/?name=' + row.name_en;
                    return '<img src="/' + imgSrc + '" class="img-thumbnail" width="50px">';
                }
            },
            { data: 'name_ar' },
            { data: 'name_en' },
            { data: 'details' },
            { data: 'status' },
            {
                data: 'id',
                render: function(data, type, row) {
                    var editUrl = `{{ route("appSlider.edit", ":id") }}`.replace(':id', data);
                    return `
                
                   
                               <a href="#" class="dropdown-item toggle-status" data-id="${data}" data-status="${row.status}">
                            <i class="fa fa-toggle-${row.status == 1 ? 'on' : 'off'}"></i> ${row.status == 1 ? 'تعطيل' : 'تمكين'}
                        </a>
                        <a href="#" class="dropdown-item delete-slider" data-id="${data}">
                            <i class="fa fa-trash"></i> حذف
                        </a>
                        
                    `;
                }
            }
        ]
    });

    $('#data-x').on('click', '.toggle-status', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: "{{ route('appSlider.toggleStatus') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "model": "AppSlider",
                "status": status
            },
            success: function(response) {
                table.ajax.reload();
            }
        });
    });

    $('#submitForm').click(function(e) {
        e.preventDefault();
        var formData = new FormData($('#store-form')[0]);
        $.ajax({
            url: "{{ route('appSlider.create') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#add-new-record').modal('hide');
                $('.form-control').removeClass('is-invalid');
                Lobibox.notify('success', {
                    title: 'Success',
                    msg: 'تمت الإضافة بنجاح.'
                });
                $('#store-form')[0].reset();
                table.ajax.reload();
            },
            error: function(xhr) {
                var errors = JSON.parse(xhr.responseText).errors;
                var errorMessages = '';
                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    errorMessages += '<li>' + value + '</li>';
                });
                $('#error-messages').html('<div class="alert alert-danger"><ul>' + errorMessages + '</ul></div>');
            }
        });
    });

    $('#data-x').on('click', '.delete-slider', function(e) {
        e.preventDefault();
        var itemId = $(this).data('id');
        $("#deleteModal").modal('show');
        $("#confirmDelete").off('click').on("click", function () {
            $.ajax({
                type: 'DELETE',
                url: "{{ route('appSlider.destroy') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': itemId,
                    'model': "AppSlider"
                },
                success: function(data) {
                    $("#deleteModal").modal('hide');
                    table.ajax.reload();
                }
            });
        });
    });

    // فتح البوب أب وتعبئة البيانات
    $('.edit-slider').on('click', function() {
        var sliderId = $(this).data('id');
        var editUrl = `{{ route("appSlider.edit", ":id") }}`.replace(':id', data);

        $.ajax({
            url:editUrl,
            type: 'GET',
            success: function(data) {
                $('#sliderId').val(data.id);
                $('#name_ar').val(data.name_ar);
                $('#name_en').val(data.name_en);
                $('#details').val(data.details);
                $('#status').val(data.status);
                $('#currentImage').attr('src', `/storage/${data.image}`);
                $('#editSliderModal').modal('show');
            }
        });
    });

    // إرسال النموذج لتحديث البيانات
    $('#editSliderForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var updateUrl = `{{ route("appSlider.update", ":id") }}`.replace(':id', data);

        $.ajax({
            url: updateUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#editSliderModal').modal('hide');
                // تحديث الجدول أو الصفحة
                location.reload();
            }
        });
    });
});
</script>
@endsection
@endsection