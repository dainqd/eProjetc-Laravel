@if(isset($col) && $col)
    <div class="col-12 col-md-{{ $col }}">
        @endif
        <div class="form-group {{ $cssClass }}">
            @if($showLabel)
                <label for="{{ $name }}">{{ $label && strlen($label) ? $label : ucfirst(strtolower($name)) }}</label>
            @endif
            <input type="{{ $type ?? 'text' }}" id="{{ $name }}" class="form-control" placeholder="{{ $placeholder }}"
                   name="{{ $name }}" value="{{ $value }}">
        </div>
        @if(isset($col) && $col)
    </div>
@endif
