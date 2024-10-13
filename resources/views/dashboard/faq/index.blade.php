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
            <span class="text-muted fw-light">FAQ</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table FAQ</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a class="send-model dt-button create-new btn btn-primary waves-effect waves-light" tabindex="0" type="button" data-bs-toggle="offcanvas" data-bs-target="#add-new-record">
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New FAQ</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Answer</th>
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
        <h5 class="offcanvas-title" id="exampleModalLabel">New FAQ</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <div id="error-messages"></div>
        
        {{ Form::open(['route' => ['faq.create'],'id'=>'store-form' , 'method' => 'POST']) }}
        
        <!-- حقل السؤال -->
        {{ Form::label('question', 'Question') }}
        {{ Form::text('question', null, ['class' => 'form-control']) }}
        
        <!-- حقل الإجابة -->
        {{ Form::label('answer', 'Answer') }}
        {{ Form::textarea('answer', null, ['class' => 'form-control']) }}

        <br>
        <br>
        <!-- زر الإرسال -->
        <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
        <!-- حقل CSRF -->
        @csrf
        {{ Form::close() }}
    </div>
</div>

@section('footer')
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/app-assets/vendors/js/extensions/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#data-x').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('faq.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'question' },
            { data: 'answer' },
            {
                data: 'id',
                render: function(data, type, row) {
                    var editUrl = `{{ route("faq.edit", ":id") }}`.replace(':id', data);
                    return `
                        <a href="#" class="dropdown-item edit-faq" data-id="${data}">
                            <i class="fa fa-pencil"></i> تعديل
                        </a>
                        <a href="#" class="dropdown-item delete-faq" data-id="${data}">
                            <i class="fa fa-trash"></i> حذف
                        </a>
                    `;
                }
            }
        ]
    });

    $('#submitForm').click(function(e) {
        e.preventDefault();
        var formData = new FormData($('#store-form')[0]);
        $.ajax({
            url: "{{ route('faq.create') }}",
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

    $('#data-x').on('click', '.edit-faq', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('faq.edit', '') }}/" + id,
            type: 'GET',
            success: function(data) {
                // ملء الحقول في الـ Modal بالبيانات المسترجعة
                $('#store-form').find('input[name="question"]').val(data.question);
                $('#store-form').find('textarea[name="answer"]').val(data.answer);
                $('#add-new-record').addClass('show'); // عرض الـ Modal
            }
        });
    });

    $('#data-x').on('click', '.delete-faq', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('faq.destroy') }}",
            type: "DELETE",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            success: function(response) {
                table.ajax.reload();
            }
        });
    });
});
</script>
@endsection
@endsection