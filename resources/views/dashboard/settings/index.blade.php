@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- عرض رسائل النجاح والأخطاء -->
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
            <span class="text-muted fw-light">Settings</span>
        </h4>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Settings</h5>
            </div>
            <div class="card-body">
                {{ Form::open(['route' => ['settings.update'], 'id' => 'settings-form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                <!-- اختيار اللغة -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('language', 'Language') }}
                        {{ Form::select('language', $languages->pluck('name', 'code'), null, ['class' => 'form-control', 'id' => 'language-select']) }}
                    </div>
                </div>

                <!-- اختيار نوع العرض (Slider أو Banner) -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('homepage_display', 'Homepage Display') }}
                        {{ Form::select('slider', [0 => 'Slider', 1 => 'Banner'],$basic['slider'] ?? 0, ['class' => 'form-control', 'id' => 'slider']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('dark_mode', 'Default Mode') }}
                        {{ Form::select('dark_mode', [1=> 'Light Mode', 0=> 'Dark Mode'],$basic['dark_mode']  ?? 1, ['class' => 'form-control', 'id' => 'dark_mode']) }}
                    </div>
                </div>

                <!-- بيانات الموقع الأساسية -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('site_name', 'Site Name') }}
                        {{ Form::text('site_name', $basic['site_name'] ?? '', ['class' => 'form-control', 'id' => 'site_name']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('phone', 'Phone Number') }}
                        {{ Form::text('phone', $basic['phone'] ?? '', ['class' => 'form-control', 'id' => 'phone']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('email', 'Email') }}
                        {{ Form::email('email', $basic['email'] ?? '', ['class' => 'form-control', 'id' => 'email']) }}
                    </div>
                </div>

                <!-- الصور والشعارات -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('logo', 'Logo') }}
                        {{ Form::file('logo', ['class' => 'form-control']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('about_image_1', 'About Us Image One') }}
                        {{ Form::file('about_image_1', ['class' => 'form-control']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('about_image_2', 'About Us Image Two') }}
                        {{ Form::file('about_image_2', ['class' => 'form-control']) }}
                    </div>
                </div>

                <!-- وصف الموقع -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        {{ Form::label('footer_description', 'Footer Description') }}
                        {{ Form::textarea('footer_description', $settings['footer_description'] ?? '', ['class' => 'form-control', 'rows'=> '2', 'id' => 'footer_description']) }}
                    </div>
                    <div class="col-md-6">
                        {{ Form::label('about_us', 'About Us') }}
                        {{ Form::textarea('about_us', $settings['about_us'] ?? '', ['class' => 'form-control', 'rows'=> '2', 'id' => 'about_us']) }}
                    </div>
                </div>

                <!-- الحقول الجديدة -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('categories_services', 'Categories Services') }}
                        {{ Form::text('categories_services', $settings['categories_services'] ?? '', ['class' => 'form-control', 'id' => 'categories_services']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('categories_creativity_and_passion', 'Categories Creativity and Passion') }}
                        {{ Form::text('categories_creativity_and_passion', $settings['categories_creativity_and_passion'] ?? '', ['class' => 'form-control', 'id' => 'categories_creativity_and_passion']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('categories_description', 'Categories Description') }}
                        {{ Form::textarea('categories_description', $settings['categories_description'] ?? '', ['class' => 'form-control', 'rows'=> '2', 'id' => 'categories_description']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('categories_start_today', 'Categories Start Today') }}
                        {{ Form::text('categories_start_today', $settings['categories_start_today'] ?? '', ['class' => 'form-control', 'id' => 'categories_start_today']) }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('services_popular_services', 'Services Popular Services') }}
                        {{ Form::text('services_popular_services', $settings['services_popular_services'] ?? '', ['class' => 'form-control', 'id' => 'services_popular_services']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('services_choose_service', 'Services Choose Service') }}
                        {{ Form::text('services_choose_service', $settings['services_choose_service'] ?? '', ['class' => 'form-control', 'id' => 'services_choose_service']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('services_subscribers', 'Services Subscribers') }}
                        {{ Form::text('services_subscribers', $settings['services_subscribers'] ?? '', ['class' => 'form-control', 'id' => 'services_subscribers']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('services_views', 'Services Views') }}
                        {{ Form::text('services_views', $settings['services_views'] ?? '', ['class' => 'form-control', 'id' => 'services_views']) }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('banner_title', 'Banner Title') }}
                        {{ Form::text('banner_title', $settings['banner_title'] ?? '', ['class' => 'form-control', 'id' => 'banner_title']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('banner_description', 'Banner Description') }}
                        {{ Form::textarea('banner_description', $settings['banner_description'] ?? '', ['class' => 'form-control', 'rows'=> '2', 'id' => 'banner_description']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('banner_button_text', 'Banner Button Text') }}
                        {{ Form::text('banner_button_text', $settings['banner_button_text'] ?? '', ['class' => 'form-control', 'id' => 'banner_button_text']) }}
                    </div>
                </div>

                <!-- روابط التواصل الاجتماعي -->
                <div class="row mb-3">
                    @foreach (['facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'snapchat', 'tiktok', 'x', 'whatsapp'] as $platform)
                    <div class="col-md-4">
                        {{ Form::label($platform, ucfirst($platform)) }}
                        {{ Form::text($platform, $basic[$platform] ?? '', ['class' => 'form-control', 'id' => $platform]) }}
                    </div>
                    @endforeach
                </div>

                <!-- زر الإرسال -->
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary" id="submitSettings">Submit</button>
                    </div>
                </div>

                @csrf
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@section('footer')
<script>
$(document).ready(function() {
    $('#language-select').change(function() {
        var selectedLanguage = $(this).val();
        $.ajax({
            url: "{{ route('settings.getFields') }}",
            type: 'GET',
            data: { language: selectedLanguage },
            success: function(data) {
                // $('#site_name').val(data.site_name);
                // $('#phone').val(data.phone);
                // $('#email').val(data.email);
                // $('#facebook').val(data.facebook);
                // $('#twitter').val(data.twitter);
                // $('#instagram').val(data.instagram);
                // $('#linkedin').val(data.linkedin);
                // $('#youtube').val(data.youtube);
                // $('#snapchat').val(data.snapchat);
                // $('#tiktok').val(data.tiktok);
                // $('#x').val(data.x);
                // $('#whatsapp').val(data.whatsapp);
                // $('#dark_mode').val(data.dark_mode);
                // $('#slider').val(data.slider);
                $('#footer_description').val(data.footer_description);
                $('#about_us').val(data.about_us);
                $('#categories_services').val(data.categories_services);
                $('#categories_creativity_and_passion').val(data.categories_creativity_and_passion);
                $('#categories_description').val(data.categories_description);
                $('#categories_start_today').val(data.categories_start_today);
                $('#services_popular_services').val(data.services_popular_services);
                $('#services_choose_service').val(data.services_choose_service);
                $('#services_subscribers').val(data.services_subscribers);
                $('#services_views').val(data.services_views);
                $('#banner_title').val(data.banner_title);
                $('#banner_description').val(data.banner_description);
                $('#banner_button_text').val(data.banner_button_text);
            }
        });
    });

    $('#submitSettings').click(function(e) {
        e.preventDefault();
        var formData = new FormData($('#settings-form')[0]);
        $.ajax({
            url: "{{ route('settings.update') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Lobibox.notify('success', {
                    title: 'Success',
                    msg: 'Settings updated successfully.'
                });
                $('.form-control').removeClass('is-invalid').addClass('is-valid');
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
});
</script>
@endsection
@endsection
