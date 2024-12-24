@extends('site.layouts.app')

@section('title', 'Order Service')
@section('content')
<div class="amazing-breadcrumb-area breadcrumb-style-3">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="amazing-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item active" aria-current="page">Order Service</li>
            </ul>
            <div class="page-title">
                <h1 class="title">Order {{ $service->title }}</h1>
            </div>
        </div>
    </div>
</div>

<section class="amazing-section-gap course-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Order Information</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('service.order.submit') }}">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="message">Message</label>
                                    <textarea id="message" name="message" class="form-control"></textarea>
                                </div>
                                <input type="hidden" name="ip_address" value="{{ request()->ip() }}">
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Service Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="thumbnail mb-3">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="Service Image" class="img-fluid">
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Price:</strong> ${{ $service->price }}
                            </li>
                            <li class="list-group-item">
                                <strong>Enrolled:</strong> {{ $service->orders->count() }} students
                            </li>
                            <li class="list-group-item">
                                <strong>Views:</strong> {{ $service->views->count() }}
                            </li>
                        </ul>
                        <div class="course-gallery mt-3">
                            <h5 class="title">Gallery</h5>
                            <div class="row">
                                @foreach($service->images as $image)
                                <div class="col-md-4 mb-3">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Service Image" class="img-fluid">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="share-area mt-3">
                            <h5 class="title">Share On:</h5>
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="#"><i class="icon-facebook"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="icon-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="icon-linkedin2"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="icon-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
