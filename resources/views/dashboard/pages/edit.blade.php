@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')
<script src="https://cdn.tiny.cloud/1/no-origin/tinymce/7.3.0-86/tinymce.min.js" referrerpolicy="origin"></script>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit </span><span>Home Page</span>
        </h4>

        <div class="app-ecommerce">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif  

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Edit Home Page Settings</div>
                            <div class="card-body">
                                <h1 class="mb-4">Edit Page</h1>
                                <div class="form-group">
                                    <label for="page-select">Select a page to edit:</label>
                                    <select id="page-select" class="form-control">
                                        <option value="">Select a page</option>
                                        @foreach($pages as $page)
                                            <option value="{{ $page->id }}">{{ $page->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <form id="update-form" style="display:none;">
               
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="page-id">
                            <div class="row">
                                <div class="col-md-6" style="display:none">
                                    <div class="form-group">
                                        <label for="name_ar">Name (AR):</label>
                                        <input type="text" id="name_ar" name="name_ar" class="form-control">
                                        <input type="number" id="id" name="id"  style="display:none">
                                    </div>
                            
                                    <div class="form-group" style="display:none">
                                        <label for="meta_ar">Meta (AR):</label>
                                        <input type="text" id="meta_ar" name="meta_ar" class="form-control">
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_en">Name (EN):</label>
                                        <input type="text" id="name_en" name="name_en" class="form-control">
                                    </div>
                            
                                    <div class="form-group">
                                        <label for="meta_en">Meta (EN):</label>
                                        <input type="text" id="meta_en" name="meta_en" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group" style="display:none">
                                <label for="description_ar">Description (AR):</label>
                                <textarea id="description_ar" name="description_ar" class="form-control"></textarea>
                            </div>
                
                            <div class="form-group">
                                <label for="description_en">Description (EN):</label>
                                <textarea id="description_en" name="description_en" class="form-control"></textarea>
                            </div>
                
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>


@section('footer')
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="{{asset('assets')}}/app-assets/vendors/js/extensions/sweetalert.min.js"></script>
<script src="{{asset('assets')}}/dashboard/js/app.js"></script>
<script>
    $(document).ready(function() {
        tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table   ',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
  });




  $('#update-form').show();

        $('#page-select').change(function() {
            var pageId = $(this).val();
            if (pageId) {
                $.ajax({
                    url: "{{ route('pages.show') }}",
                    type: 'GET',
                       data: { id : pageId},
                    success: function(data) {
                        $('#page-id').val(data.id);
                        $('#id').val(data.id);
                        $('#name_ar').val(data.name_ar);
                        $('#name_en').val(data.name_en);
                        $('#meta_ar').val(data.meta_ar);
                        $('#meta_en').val(data.meta_en);
                        $('#description_ar').val(data.description_ar);
                        $('#description_en').val(data.description_en);
                        tinymce.get('description_ar').setContent(data.description_ar);
                        tinymce.get('description_en').setContent(data.description_en);
                        $('#update-form').show();
                    }
                });
            } else {
                $('#update-form').hide();
            }
        });
        
        $('#update-form').submit(function(e) {
            e.preventDefault();
            var pageId = $('#page-id').val();
            $.ajax({
                url: "{{ route('pages.update') }}",
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response.message);
                }
            });
        });
    });
</script>
@endsection
@endsection


