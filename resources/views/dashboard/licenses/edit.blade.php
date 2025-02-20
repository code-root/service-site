@extends('dashboard.layouts.navbar')
@extends('dashboard.layouts.footer')

@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit Licenses</span>
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
                <h5 class="mb-0">Edit License Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('license.update', $license->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="activation_code" class="form-label">Activation Code</label>
                        <input type="text" name="activation_code" id="activation_code" class="form-control" value="{{ $license->activation_code }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="client_id" class="form-label">Client</label>
                        <select name="client_id" id="client_id" class="form-select" required>
                            @foreach($clients as $item)
                                <option value="{{ $item->id }}" {{ $license->client_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="program_id" class="form-label">Program</label>
                        <select name="program_id" id="program_id" class="form-select" required>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ $license->program_id == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" id="is_active" value="{{ $license->is_active }}" class="form-check-input" {{ $license->is_active ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">License Active</label>
                    </div>
                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="date" name="purchase_date" id="purchase_date" class="form-control" value="{{ \Carbon\Carbon::parse($license->purchase_date)->format('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="expiry_date" class="form-label">Expiry Date</label>
                        <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ \Carbon\Carbon::parse($license->expiry_date)->format('Y-m-d') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update License</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
