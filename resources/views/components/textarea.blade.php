@if(isset($col) && $col)
    <div class="col-12 col-md-{{ $col }}">
        @endif
        <div class="form-group {{ $cssClass }}">
            <label for="{{ $name }}">{{ $label && strlen($label) ? $label : ucfirst(strtolower($name)) }}</label>
            <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" class="form-control">{{ $value }}</textarea>
        </div>
        @if(isset($col) && $col)
    </div>
@endif
