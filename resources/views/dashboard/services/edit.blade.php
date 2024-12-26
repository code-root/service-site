@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit Service</span>
        </h4>

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

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Service Information</h5>
                    </div>
                    <form method="post" action="{{ route('service.update', $service->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="price">Price</label>
                                    <input type="number" id="price" name="price" class="form-control" value="{{ $service->price }}" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="images">Images</label>
                                    <input type="file" id="images" name="images[]" class="form-control" multiple>
                                    <div class="mt-3">
                                        @foreach($service->images as $image)
                                        <div class="image-preview" style="display: inline-block; position: relative;">
                                            <img src="{{ asset('/storage/app/public/' . $image->path) }}" alt="Service Image" class="img-thumbnail" style="width: 100px; height: 100px;">
                                            <button type="button" class="btn btn-danger btn-sm delete-image" data-id="{{ $image->id }}" style="position: absolute; top: 0; right: 0;">&times;</button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" id="token" name="token" value="{{ $service->token }}" class="form-control">
                            </div>

                            <h5 class="mt-4">Edit Service Texts</h5>
                            <div class="mb-3">
                                <label class="form-label" for="language">Select Language</label>
                                <select id="language" name="language_id" class="form-control" required>
                                    @foreach($languages as $language)
                                    <option value="{{ $language->id }}" {{ defaultLanguage() == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="language-fields">
                                @foreach ($txt as $key => $field)
                                <div class="language-row mb-3">
                                    <label class="form-label mt-2" for="{{ $key }}">{{ $field['label'] }}</label>
                                    @if ($field['type'] === 'input')
                                    <input type="text" name="{{ $key }}[{{ defaultLanguage() }}]" class="form-control" value="{{ $service->translations->where('key', $key)->first()->value ?? '' }}" required>
                                    @elseif ($field['type'] === 'textarea')
                                    <textarea name="{{ $key }}[{{ defaultLanguage() }}]" class="form-control" required>{{ $service->translations->where('key', $key)->first()->value ?? '' }}</textarea>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Service</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script src="{{ asset('assets/app-assets/vendors/js/extensions/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
<script>
$(document).ready(function() {

tinymce.init({
    selector: 'textarea',
    height: 400,
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
    toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | link image | code',
    branding: false,
    setup: function (editor) {
        editor.on('keyup', saveTextData);
    }
});

    // عند تغيير اللغة
    $('#language').change(function() {
        var languageId = $(this).val();
        var item_id = {{ $service->id }}; // الحصول على ID الخدمة

        $.ajax({

            url: "{{ route('service.getTranslations') }}",
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'language_id': languageId,
                'item_id': item_id
            },
            success: function(translations) {
                // مسح الحقول الحالية
                $('#language-fields').empty();

                // إضافة الحقول الجديدة
                translations.forEach(function(translation) {
                    // تحقق من أن المفتاح ليس 'language_id' أو 'token'
                    if (translation.key !== 'language_id' && translation.key !== 'token') {
                        var fieldHtml = `
                            <div class="language-row mb-3">
                                <label class="form-label mt-2" for="${translation.key}">${translation.key}</label>
                                <input type="text" name="${translation.key}[${translation.language_id}]" class="form-control" value="${translation.value || ''}" required>
                            </div>
                        `;
                        $('#language-fields').append(fieldHtml);
                    }
                });
                if (translations.length === 0) {
                    @foreach ($txt as $key => $field)
                        var fieldHtml = `
                            <div class="language-row mb-3">
                                <label class="form-label mt-2" for="{{ $key }}">{{ $field['label'] }}</label>
                                @if ($field['type'] === 'input')
                                    <input type="text" name="{{ $key }}[${languageId}]" class="form-control" value="" required>
                                @elseif ($field['type'] === 'textarea')
                                    <textarea name="{{ $key }}[${languageId}]" class="form-control" required></textarea>
                                @endif
                            </div>
                        `;
                        $('#language-fields').append(fieldHtml);
                    @endforeach
                }
            }
        });
    });

    // حذف الصورة
    $('.delete-image').click(function() {
        var imageId = $(this).data('id');
        var imageElement = $(this).closest('.image-preview');

        $.ajax({
            url: "{{ route('image.delete') }}",
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': imageId
            },
            success: function(response) {
                imageElement.remove();
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    });
});
</script>
@endsection
@endsection
