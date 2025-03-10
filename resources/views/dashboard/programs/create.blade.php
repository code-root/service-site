@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div id="alert-success" class="alert alert-success d-none">
            <p id="success-message"></p>
        </div>

        <div id="alert-danger" class="alert alert-danger d-none">
            <ul id="error-messages"></ul>
        </div>

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Add New Program</span>
        </h4>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add New Program</h5>
            </div>
            <div class="card-body">
                <form id="programForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Program Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Program Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Program</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('programForm').addEventListener('submit', function(event) {
    event.preventDefault();
    let formData = new FormData(this);

    fetch('{{ route('program.store') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.errors) {
            let errorMessages = '';
            for (const [key, value] of Object.entries(data.errors)) {
                errorMessages += `<li>${value[0]}</li>`;
            }
            document.getElementById('error-messages').innerHTML = errorMessages;
            document.getElementById('alert-danger').classList.remove('d-none');
            document.getElementById('alert-success').classList.add('d-none');
        } else {
            document.getElementById('success-message').textContent = data.success;
            document.getElementById('alert-success').classList.remove('d-none');
            document.getElementById('alert-danger').classList.add('d-none');
            document.getElementById('programForm').reset();
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>

@endsection