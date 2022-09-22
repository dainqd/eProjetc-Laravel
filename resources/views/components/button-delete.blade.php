<a type="button" class="btn btn-danger" data-bs-toggle="modal"
   data-bs-target="#delete-{{ $id }}">Delete</a>
<div class="modal fade" id="delete-{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ isset($content) && strlen($content) ? $content : 'Are you sure you want to delete this?' }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ $href }}" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
