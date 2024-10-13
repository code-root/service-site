@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

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
@endif    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Home Page Settings</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('homepagesettings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="image_description">Image Description</label>
                            <input type="file" class="form-control" id="image_path" name="image_path">
                            @if($settings->image_description)
                                <img src="/{{ $settings->image_description }}" alt="Image Description">
                            @endif
                        </div>

                        {{-- <div class="form-group">
                            <label for="title1">Title 1</label>
                            <input type="text" class="form-control" id="title1" name="title1" value="{{ $settings->title1 }}">
                        </div>

                        <div class="form-group">
                            <label for="title2">Title 2</label>
                            <input type="text" class="form-control" id="title2" name="title2" value="{{ $settings->title2 }}">
                        </div>

                        <div class="form-group">
                            <label for="title3">Title 3</label>
                            <input type="text" class="form-control" id="title3" name="title3" value="{{ $settings->title3 }}">
                        </div>
 --}}

                        <div class="form-group">
                            <label for="title_description">Title Description</label>
                            <textarea class="form-control" id="title_description" name="title_description">{{ $settings->title_description }}</textarea>
                        </div>

                        <div class="form-group ">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" rows="20" name="description">{{ $settings->description }}</textarea>
                        </div>
                        <div class="form-group ">

                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                    </form>
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

@endsection
@endsection


