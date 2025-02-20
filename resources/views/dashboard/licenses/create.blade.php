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
                        <!-- كود التفعيل -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="activation_code">Activation code</label>
                                <input type="text" name="activation_code" id="activation_code" class="form-control" required>
                                <small id="encoded_key" class="form-text text-muted" style="font-size:bold"></small>
                            </div>
                        </div>

                        <!-- client -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id">client</label>
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
@endsection

@section('footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function generateKey(s) {
        let h = s;
        h = h.replace(/A/g, "D")
            .replace(/B/g, "M")
            .replace(/C/g, "N")
            .replace(/D/g, "C")
            .replace(/E/g, "K")
            .replace(/F/g, "K")
            .replace(/G/g, "Y")
            .replace(/H/g, "Q")
            .replace(/I/g, "X")
            .replace(/J/g, "Z")
            .replace(/K/g, "Z")
            .replace(/L/g, "Y")
            .replace(/M/g, "F")
            .replace(/N/g, "Z")
            .replace(/O/g, "M")
            .replace(/P/g, "T")
            .replace(/Q/g, "O")
            .replace(/R/g, "S")
            .replace(/S/g, "K")
            .replace(/T/g, "Z")
            .replace(/U/g, "O")
            .replace(/V/g, "Z")
            .replace(/W/g, "T")
            .replace(/X/g, "P")
            .replace(/Y/g, "Q")
            .replace(/Z/g, "N")
            .replace(/1/g, "8")
            .replace(/2/g, "5")
            .replace(/3/g, "9")
            .replace(/4/g, "3")
            .replace(/5/g, "1")
            .replace(/6/g, "7")
            .replace(/7/g, "2")
            .replace(/8/g, "6")
            .replace(/9/g, "8")
            .replace(/0/g, "1")
            .replace(/-/g, "");
        let n = "";
        for (let i = 0; i < h.length - 7; i++) {
            n += h[i];
        }
        return n;
    }

    // إرسال الكود عبر AJAX وتشفيره
    $('#activation_code').on('input', function() {
        const code = $(this).val();
        const encryptedCode = generateKey(code);

        $('#encoded_key').text("الكود المشفر: " + encryptedCode);
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
                    alert('تم Add License بنجاح');
                    window.location.href = '{{ route("license.index") }}';
                }
            },
            error: function(xhr) {
                alert('حدث خطأ يرجى المحاولة لاحقًا');
            }
        });
    });
</script>
@endsection
