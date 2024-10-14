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
            <span class="text-muted fw-light">Settings</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Settings</h5>
            </div>
            <div class="card-body">
                {{ Form::open(['route' => ['settings.update'], 'id' => 'settings-form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                <!-- اختيار اللغة -->
                {{ Form::label('language', 'Select Language') }}
                {{ Form::select('language', ['en' => 'English', 'ar' => 'العربية'], null, ['class' => 'form-control', 'id' => 'language-select']) }}

                <div id="error-messages"></div>

                <div class="row">
                    <!-- حقل اسم الموقع -->
                    <div class="col-md-4">
                        {{ Form::label('site_name', 'Site Name') }}
                        {{ Form::text('site_name', $settings['site_name'] ?? '', ['class' => 'form-control', 'id' => 'site_name']) }}
                    </div>

                    <!-- حقل رقم الهاتف -->
                    <div class="col-md-4">
                        {{ Form::label('phone', 'Phone Number') }}
                        {{ Form::text('phone', $settings['phone'] ?? '', ['class' => 'form-control', 'id' => 'phone']) }}
                    </div>

                    <!-- حقل البريد الإلكتروني -->
                    <div class="col-md-4">
                        {{ Form::label('email', 'Email') }}
                        {{ Form::email('email', $settings['email'] ?? '', ['class' => 'form-control', 'id' => 'email']) }}
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- حقل الشعار -->
                    <div class="col-md-4">
                        {{ Form::label('logo', 'Logo') }}
                        {{ Form::file('logo', ['class' => 'form-control']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('about us image One', 'about_image_1') }}
                        {{ Form::file('about_image_1', ['class' => 'form-control']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('about us image two', 'about_image_2') }}
                        {{ Form::file('about_image_2', ['class' => 'form-control']) }}
                    </div>

                    <!-- حقل وصف الفوتر -->
                    <div class="col-md-4">
                        {{ Form::label('footer_description', 'Footer Description') }}
                        {{ Form::textarea('footer_description', $settings['footer_description'] ?? '', ['class' => 'form-control', 'rows'=> '1', 'id' => 'footer_description']) }}
                    </div>

                            <!-- حقل وصف الفوتر -->
                            <div class="col-md-4">
                        {{ Form::label('about_us', 'about Us') }}
                        {{ Form::textarea('about_us', $settings['about_us'] ?? '', ['class' => 'form-control', 'rows'=> '1', 'id' => 'about_us']) }}
                    </div>

                    
                </div>

                <div class="row mt-3">
                    <!-- حقل مقدمة من نحن -->
                    <div class="col-md-4">
                        {{ Form::label('about_intro', 'About Us - Introduction') }}
                        {{ Form::textarea('about_intro', $settings['about_intro'] ?? '', ['class' => 'form-control', 'id' => 'about_intro']) }}
                    </div>

                    <!-- حقل مهمة من نحن -->
                    <div class="col-md-4">
                        {{ Form::label('about_mission', 'About Us - Mission') }}
                        {{ Form::textarea('about_mission', $settings['about_mission'] ?? '', ['class' => 'form-control', 'id' => 'about_mission']) }}
                    </div>

                    <!-- حقل رؤية من نحن -->
                    <div class="col-md-4">
                        {{ Form::label('about_vision', 'About Us - Vision') }}
                        {{ Form::textarea('about_vision', $settings['about_vision'] ?? '', ['class' => 'form-control', 'id' => 'about_vision']) }}
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- إعدادات الأسئلة الشائعة -->
                    <div class="col-md-4">
                        {{ Form::label('faq_pre_title', 'FAQ Pre-title') }}
                        {{ Form::text('faq_pre_title', $settings['faq_pre_title'] ?? '', ['class' => 'form-control', 'id' => 'faq_pre_title']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('faq_title', 'FAQ Title') }}
                        {{ Form::text('faq_title', $settings['faq_title'] ?? '', ['class' => 'form-control', 'id' => 'faq_title']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('faq_description', 'FAQ Description') }}
                        {{ Form::textarea('faq_description', $settings['faq_description'] ?? '', ['class' => 'form-control', 'rows'=> '1', 'id' => 'faq_description']) }}
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- عناوين الاتصال -->
                    <div class="col-md-4">
                        {{ Form::label('contact_title', 'Contact Title') }}
                        {{ Form::textarea('contact_title', $settings['contact_title'] ?? '', ['class' => 'form-control', 'id' => 'contact_title']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('contact_title_2', 'Contact Title 2') }}
                        {{ Form::textarea('contact_title_2', $settings['contact_title_2'] ?? '', ['class' => 'form-control', 'id' => 'contact_title_2']) }}
                    </div>
                    <div class="col-md-4">

                    {{ Form::label('google_maps', 'Google Maps Embed') }}
                        {{ Form::textarea('google_maps', $settings['google_maps'] ?? '', ['class' => 'form-control', 'id' => 'google_maps']) }}
                        </div>
                    
                </div>

                <div class="row mt-3">
                    <!-- مواقع التواصل الاجتماعي -->
                    <div class="col-md-4">
                        {{ Form::label('facebook', 'Facebook') }}
                        {{ Form::text('facebook', $settings['facebook'] ?? '', ['class' => 'form-control', 'id' => 'facebook']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('twitter', 'Twitter') }}
                        {{ Form::text('twitter', $settings['twitter'] ?? '', ['class' => 'form-control', 'id' => 'twitter']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('instagram', 'Instagram') }}
                        {{ Form::text('instagram', $settings['instagram'] ?? '', ['class' => 'form-control', 'id' => 'instagram']) }}
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        {{ Form::label('linkedin', 'LinkedIn') }}
                        {{ Form::text('linkedin', $settings['linkedin'] ?? '', ['class' => 'form-control', 'id' => 'linkedin']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('youtube', 'YouTube') }}
                        {{ Form::text('youtube', $settings['youtube'] ?? '', ['class' => 'form-control', 'id' => 'youtube']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('snapchat', 'Snapchat') }}
                        {{ Form::text('snapchat', $settings['snapchat'] ?? '', ['class' => 'form-control', 'id' => 'snapchat']) }}
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        {{ Form::label('tiktok', 'TikTok') }}
                        {{ Form::text('tiktok', $settings['tiktok'] ?? '', ['class' => 'form-control', 'id' => 'tiktok']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('x', 'X') }}
                        {{ Form::text('x', $settings['x'] ?? '', ['class' => 'form-control', 'id' => 'x']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::label('whatsapp', 'WhatsApp') }}
                        {{ Form::text('whatsapp', $settings['whatsapp'] ?? '', ['class' => 'form-control', 'id' => 'whatsapp']) }}
                    </div>
                </div>

                <br>
                <button type="button" class="btn btn-primary" id="submitSettings">Submit</button>
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
                $('#footer_description').val(data.footer_description);
                $('#about_intro').val(data.about_intro);
                $('#about_mission').val(data.about_mission);
                $('#about_vision').val(data.about_vision);
                $('#faq_pre_title').val(data.faq_pre_title);
                $('#faq_title').val(data.faq_title);
                $('#faq_description').val(data.faq_description);
                $('#contact_title').val(data.contact_title);
                $('#contact_title_2').val(data.contact_title_2);
                $('#about_us').val(data.about_us);
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

                // إزالة اللون الأحمر وإضافة اللون الأخضر للحقول
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