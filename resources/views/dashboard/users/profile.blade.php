@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">إعدادات الحساب /</span> الحساب
            </h4>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">تفاصيل الملف الشخصي</h5>
                        <!-- Account -->
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="/storage{{ ( $data->avatar ? $data->avatar :'/app/admin-avatar/admin.png' ) }}"  alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">رفع صورة جديدة</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="avatar" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">إعادة تعيين</span>
                                    </button>
                                    <p class="text-muted mb-0">مسموح JPG, GIF أو PNG. الحجم الأقصى 800K</p>
                                </div>
                            </div>
                            
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">الاسم الأول</label>
                                        <input class="form-control" type="text" id="firstName" name="firstName"
                                            value="{{ $data->name }}" autofocus />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">البريد الإلكتروني</label>
                                        <input class="form-control" type="email" id="email" name="email"
                                            value="{{ $data->email }}" placeholder="example@example.com" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phoneNumber">رقم الهاتف</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">KSA (+966)</span>
                                            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                                value="{{ $data->phone }}" placeholder="0123456789" />
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">حفظ التغييرات</button>
                                    <button type="reset" class="btn btn-label-secondary">إلغاء</button>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
    </div>
@endsection
@section('footer-script')
    <script>
    $('#formAccountSettings').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: '{{ route("admin.profile.update") }}', // يجب إنشاء هذا المسار
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if(response.status === 'success') {
                // تحديث الصورة المعروضة بعد النجاح
                if(response.avatar) {
                    $('#uploadedAvatar').attr('src', response.avatar);
                }
                alert('تم حفظ التغييرات بنجاح');
            } else {
                alert('حدث خطأ ما، حاول مرة أخرى');
            }
        },
        error: function(response) {
            alert('حدث خطأ ما، حاول مرة أخرى');
        }
    });
});

// AJAX لإعادة تعيين الصورة
$('.account-image-reset').on('click', function() {
    $('#uploadedAvatar').attr('src', '../../assets/img/avatars/1.png');
    $('#upload').val('');
});

// عرض الصورة مباشرة بعد اختيار الملف
$('#upload').on('change', function() {
    console.log('d');
    const [file] = this.files;
    if (file) {
        $('#uploadedAvatar').attr('src', URL.createObjectURL(file));
    }
});

    </script>
@endsection
