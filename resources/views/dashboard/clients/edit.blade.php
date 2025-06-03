@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit Client</span>
        </h4>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Client Information</h5>
            </div>
            <div class="card-body">
                <form id="editClientForm" action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $client->name }}" required>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $client->id }}" required hidden >
                        <div class="text-danger error-message mt-1" id="name-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ $client->location }}" required>
                        <div class="text-danger error-message mt-1" id="location-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $client->phone }}" required>
                        <div class="text-danger error-message mt-1" id="phone-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $client->email }}" required>
                         <div class="text-danger error-message mt-1" id="email-error"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Client</button>
                </form>
                 <div id="success-message" class="alert alert-success mt-3" style="display: none;"></div>
                 <div id="error-message" class="alert alert-danger mt-3" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#editClientForm').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous messages
        $('.error-message').text('');
        $('#success-message').hide();
        $('#error-message').hide();
        
        var formData = $(this).serialize();
        var url = $(this).attr('action');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    $('#success-message').text(response.success).show();
                    // Optional: Redirect after a delay
                    // setTimeout(function() {
                    //     window.location.href = "{{ route('clients.index') }}";
                    // }, 2000);
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + '-error').text(value[0]);
                    });
                } else {
                    $('#error-message').text('An error occurred. Please try again.').show();
                }
            }
        });
    });
});
</script>
@endsection