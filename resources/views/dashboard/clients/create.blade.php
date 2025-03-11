@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<style>
.invalid-feedback {
    display: block!important;
}
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Add Client</span>
        </h4>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add New Client</h5>
            </div>
            <div class="card-body">
                <form id="clientForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback" id="nameError" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" >
                        <div class="invalid-feedback" id="locationError" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" >
                        <div class="invalid-feedback" id="phoneError" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="invalid-feedback" id="emailError" style="display: none;"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Client</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#clientForm').on('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '{{ route('clients.store') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            success: function(data) {
                // Clear previous error messages
                $('#nameError').text('').hide();
                $('#locationError').text('').hide();
                $('#phoneError').text('').hide();
                $('#emailError').text('').hide();

                if (data.errors) {
                    if (data.errors.name) {
                        $('#nameError').text(data.errors.name[0]).show();
                    }
                    if (data.errors.location) {
                        $('#locationError').text(data.errors.location[0]).show();
                    }
                    if (data.errors.phone) {
                        $('#phoneError').text(data.errors.phone[0]).show();
                    }
                    if (data.errors.email) {
                        $('#emailError').text(data.errors.email[0]).show();
                    }
                } else {
                    window.location.href = '{{ route('clients.index') }}';
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors.name) {
                    $('#nameError').text(errors.name[0]).show();
                }
                if (errors.location) {
                    $('#locationError').text(errors.location[0]).show();
                }
                if (errors.phone) {
                    $('#phoneError').text(errors.phone[0]).show();
                }
                if (errors.email) {
                    $('#emailError').text(errors.email[0]).show();
                }
            }
        });
    });
});
</script>
@endsection
