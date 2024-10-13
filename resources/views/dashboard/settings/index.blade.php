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
                
                <!-- حقل اسم الموقع -->
                {{ Form::label('site_name', 'Site Name') }}
                {{ Form::text('site_name', $settings['site_name'] ?? '', ['class' => 'form-control']) }}

                <!-- حقل الشعار -->
                {{ Form::label('logo', 'Logo') }}
                {{ Form::file('logo', ['class' => 'form-control']) }}

                <!-- حقل رقم الهاتف -->
                {{ Form::label('phone', 'Phone Number') }}
                {{ Form::text('phone', $settings['phone'] ?? '', ['class' => 'form-control']) }}

                <!-- حقل البريد الإلكتروني -->
                {{ Form::label('email', 'Email') }}
                {{ Form::email('email', $settings['email'] ?? '', ['class' => 'form-control']) }}

                <!-- حقل وصف الفوتر -->
                {{ Form::label('footer_description', 'Footer Description') }}
                {{ Form::textarea('footer_description', $settings['footer_description'] ?? '', ['class' => 'form-control']) }}

                <!-- حقل مقدمة من نحن -->
                {{ Form::label('about_intro', 'About Us - Introduction') }}
                {{ Form::textarea('about_intro', $settings['about_intro'] ?? '', ['class' => 'form-control']) }}

                <!-- حقل مهمة من نحن -->
                {{ Form::label('about_mission', 'About Us - Mission') }}
                {{ Form::textarea('about_mission', $settings['about_mission'] ?? '', ['class' => 'form-control']) }}

                <!-- حقل رؤية من نحن -->
                {{ Form::label('about_vision', 'About Us - Vision') }}
                {{ Form::textarea('about_vision', $settings['about_vision'] ?? '', ['class' => 'form-control']) }}

                <!-- إعدادات الأسئلة الشائعة -->
                {{ Form::label('faq_pre_title', 'FAQ Pre-title') }}
                {{ Form::text('faq_pre_title', $settings['faq_pre_title'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('faq_title', 'FAQ Title') }}
                {{ Form::text('faq_title', $settings['faq_title'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('faq_description', 'FAQ Description') }}
                {{ Form::textarea('faq_description', $settings['faq_description'] ?? '', ['class' => 'form-control']) }}


                {{ Form::label('contact_title', 'contact_title') }}
                {{ Form::textarea('contact_title', $settings['contact_title'] ?? '', ['class' => 'form-control']) }}


                {{ Form::label('contact_title_2', 'contact_title_2') }}
                {{ Form::textarea('contact_title_2', $settings['contact_title_2'] ?? '', ['class' => 'form-control']) }}

                
                <!-- مواقع التواصل الاجتماعي -->
                {{ Form::label('facebook', 'Facebook') }}
                {{ Form::text('facebook', $settings['facebook'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('twitter', 'Twitter') }}
                {{ Form::text('twitter', $settings['twitter'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('instagram', 'Instagram') }}
                {{ Form::text('instagram', $settings['instagram'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('linkedin', 'LinkedIn') }}
                {{ Form::text('linkedin', $settings['linkedin'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('youtube', 'YouTube') }}
                {{ Form::text('youtube', $settings['youtube'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('snapchat', 'Snapchat') }}
                {{ Form::text('snapchat', $settings['snapchat'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('tiktok', 'TikTok') }}
                {{ Form::text('tiktok', $settings['tiktok'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('x', 'X') }}
                {{ Form::text('x', $settings['x'] ?? '', ['class' => 'form-control']) }}

                {{ Form::label('whatsapp', 'whatsapp') }}
                {{ Form::text('whatsapp', $settings['whatsapp'] ?? '', ['class' => 'form-control']) }}


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