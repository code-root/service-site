@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit licenses</span>
        </h4>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit licenses Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('licenses.update', $license->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="activation_code">كود التفعيل</label>
                        <input type="text" name="activation_code" id="activation_code" class="form-control" value="{{ $license->activation_code }}" required>
                    </div>

                    <div class="form-group">
                        <label for="licenses_id">العميل</label>
                        <select name="licenses_id" id="licenses_id" class="form-control" required>
                            @foreach($licensess as $licenses)
                                <option value="{{ $licenses->id }}" {{ $license->licenses_id == $licenses->id ? 'selected' : '' }}>{{ $licenses->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="program_id">البرنامج</label>
                        <select name="program_id" id="program_id" class="form-control" required>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ $license->program_id == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="is_active">حالة الترخيص</label>
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $license->is_active ? 'checked' : '' }}>
                    </div>

                    <div class="form-group">
                        <label for="purchase_date">تاريخ الشراء</label>
                        <input type="date" name="purchase_date" id="purchase_date" class="form-control" value="{{ $license->purchase_date }}" required>
                    </div>

                    <div class="form-group">
                        <label for="expiry_date">تاريخ الانتهاء</label>
                        <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ $license->expiry_date }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">تحديث الترخيص</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
