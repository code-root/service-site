@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Add License</span>
        </h4>

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

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add new license</h5>
            </div>
            <div class="card-body">
                <form id="license-form">
                    @csrf
                    <div class="row">
                        <!-- Activation code -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="activation_code">Activation code</label>
                                <input type="text" name="activation_code" id="activation_code" class="form-control" required>
                                {{-- <small id="encoded_key" class="form-text text-muted" style="font-size:bold"></small> --}}
                            </div>
                        </div>

                        <!-- Encoded Key -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="encoded_key">Encoded Key</label>
                                <input type="text" id="encoded_key" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Client -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id">Client</label>
                                <select name="client_id" id="client_id" class="form-control" required>
                                    @foreach($clients as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Program -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="program_id">Program</label>
                                <select name="program_id" id="program_id" class="form-control" required>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Purchase date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purchase_date">Purchase date</label>
                                <input type="date" name="purchase_date" id="purchase_date" class="form-control" required>
                            </div>
                        </div>

                        <!-- Expiry date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expiry_date">Expiry date</label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add License</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                License added successfully.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                An error occurred. Please try again later.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // إرسال الكود عبر AJAX لتشفيره
    $('#activation_code').on('input', function() {
        const code = $(this).val();

        $.ajax({
            url: '{{ route("licenses.encrypt") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                activation_code: code
            },
            success: function(response) {
                $('#encoded_key').val(response.encryptedCode);
            },
            error: function(xhr) {
                console.error('An error occurred while encrypting the code.');
            }
        });
    });

    // عند إرسال النموذج
    $('#license-form').submit(function(event) {
        event.preventDefault(); // منع إرسال النموذج بشكل تقليدي

        const formData = $(this).serialize();

        $.ajax({
            url: '{{ route("licenses.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    $('#successModal').modal('show');
                }
            },
            error: function(xhr) {
                $('#errorModal').modal('show');
            }
        });
    });
</script>
@endsection
