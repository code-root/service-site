@extends('site.layouts.app')

@section('title', $service->title)
@section('content')
<div class="amazing-breadcrumb-area breadcrumb-style-3">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="amazing-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item"><a href="">Services</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item active" aria-current="page">{{  getTranslations($service->tr_token ,  'title')  }}</li>
            </ul>
            <div class="page-title">
                <h1 class="title">{{  getTranslations($service->tr_token ,  'title')  }}</h1>
            </div>
            <ul class="course-meta">
                <li><i class="icon-24"></i> {{ $service->orders->count() }} المشتركين</li>
                <li><i class="icon-25"></i> {{ $service->views->count() }} المشاهدات</li>
            </ul>
        </div>
    </div>
</div>

<section class="amazing-section-gap course-details-area">
    <div class="container">
        <div class="row row--30">
            <div class="col-lg-8">
                <div class="course-details-content">
                    <div class="course-overview">
                        <h3 class="heading-title">Service Description</h3>
                        <p>{!!  getTranslations($service->tr_token ,  'description')  !!}</p>
                    </div>
                    <div class="course-gallery">
                        <h5 class="title">Gallery</h5>
                        <div class="row">
                            @foreach($service->images as $image)
                            <div class="col-md-4">
                                <img src="{{ asset('/storage/app/public/' . $image->path) }}" alt="Service Image" class="img-fluid">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="course-sidebar-3 sidebar-top-position">
                    <div class="amazing-course-widget widget-course-summery">
                        <div class="inner">
                            <div class="thumbnail">
                                <img src="{{ asset('/storage/app/public/' .$service->image) }}" alt="Service Image">
                            </div>
                            <div class="content">
                                <h4 class="widget-title">Service Includes:</h4>
                                <ul class="course-item">
                                    <li>
                                        <span class="label"><i class="icon-60"></i>Price:</span>
                                        <span class="value price">${{ $service->price }}</span>
                                    </li>
                                    <li>
                                        <span class="label"><i class="icon-63"></i>Enrolled:</span>
                                        <span class="value">{{ $service->orders->count() }} students</span>
                                    </li>
                                    <li>
                                        <span class="label"><i class="icon-25"></i>Views:</span>
                                        <span class="value">{{ $service->views->count() }}</span>
                                    </li>
                                </ul>
                                <div class="share-area">
                                    <h4 class="title">Share On:</h4>
                                    <ul class="social-share">
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank">
                                                <i class="icon-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}&text={{ urlencode($service->title) }}" target="_blank">
                                                <i class="icon-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(Request::fullUrl()) }}&title={{ urlencode($service->title) }}" target="_blank">
                                                <i class="icon-linkedin2"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.youtube.com/share?url={{ urlencode(Request::fullUrl()) }}" target="_blank">
                                                <i class="icon-youtube"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="subscription-form" class="contact-form form-style-2 mt-5">
                        <div class="section-title">
                            <h4 class="title">Subscribe to this Service</h4>
                            <p>Fill out this form to subscribe to this service.</p>
                        </div>
                        <form action="" id="subscribe-form" method="POST">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <div class="row row--10">
                                <div class="form-group col-12">
                                    <label for="name">Your Name</label>
                                    <input type="text" name="name" id="name" placeholder="Your name" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" placeholder="Phone number" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="subscription_duration">Subscription Duration (months)</label>
                                    <input type="number" name="subscription_duration" id="subscription_duration" placeholder="Subscription duration" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="message">Your Message</label>
                                    <textarea name="message" id="message" cols="30" rows="4" placeholder="Your message"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button class="rn-btn amazing-btn btn-medium submit-btn" type="submit">Submit <i class="icon-4"></i></button>
                                </div>
                            </div>
                        </form>
                        <div id="form-messages" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>

    $(document).ready(function() {
        console.log('dd');
        $('#subscribe-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('service.subscribe') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    $('#form-messages').html('<div class="alert alert-success">' + response.message + '</div>');
                    $('#subscribe-form')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '<div class="alert alert-danger"><ul>';
                        $.each(errors, function(key, value) {
                            errorMessages += '<li>' + value[0] + '</li>';
                        });
                        errorMessages += '</ul></div>';
                        $('#form-messages').html(errorMessages);
                    } else {
                        $('#form-messages').html('<div class="alert alert-danger">An error occurred. Please try again later.</div>');
                    }
                }
            });
        });
    });
</script>
@endsection
