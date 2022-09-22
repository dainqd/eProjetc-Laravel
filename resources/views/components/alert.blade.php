@props(
    ['type' => 'info', 'key' => 'message']
)

@if (session()->has($key))
    <div class="alert alert-{{$type}} alert-dismissible show fade">
        {{ $content ?? session()->get($key) }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
