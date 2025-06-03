@can('edit-licenses')
<a href="{{ $editUrl }}" class="btn btn-warning btn-sm">
    <i class="fa fa-pencil"></i> Edit
</a>
@endcan

@can('delete-licenses')
<form action="{{ $deleteUrl }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm delete-licenses" data-id="{{ $license->id }}">
        <i class="fa fa-trash"></i> Delete
    </button>
</form>
@endcan