@if(isset($col) && $col)
    <div class="col-12 col-md-{{ $col }}">
        @endif
        <div class="form-group {{ $cssClass }}">
            <label for="{{ $name }}">{{ $label && strlen($label) ? $label : ucfirst(strtolower($name)) }}</label>
            <input type="hidden" id="{{ $name }}" class="form-control"
                   value="{{ $value }}" name="{{ $name }}">
            <div class="form-group d-flex flex-column align-items-center">
                <img alt="Single image upload" id="preview-photo-{{ $name }}" style="max-width: 100%; {{ !$value || !strlen($value) ? 'display: none;' : '' }}"
                     class="mt-4" src="{{ $value }}">
                <button type="button" class="btn btn-primary btn-block mt-3" id="upload-photo">
                    <i class="fas fa-image"></i>{{ $placeholder && strlen($placeholder) ? $placeholder : 'Tải ảnh lên' }}
                </button>
            </div>
        </div>
        @if(isset($col) && $col)
    </div>
@endif

<script>
    window.addEventListener('DOMContentLoaded', function () {
        const inputPhoto = $('#{{ $name }}');
        cloudinary.setCloudName('nguy-n-ng-c-thu-n');
        $('#upload-photo').click(function () {
            cloudinary.openUploadWidget({
                    uploadPreset: 'sem_2_project',
                    sources: ['local', 'url', 'image_search', 'google_drive'],
                    multiple: false,
                    tags: ['browser_upload'],
                    resourceType: 'image',
                    cropping: true,
                    croppingAspectRatio: 1,
                    thumbnails: false,
                    autoMinimize: true
                }, (error, result) => {
                    if (!error && result && result.event === "success") {
                        $('#preview-photo-{{ $name }}').attr('src', result.info.url).show();
                        inputPhoto.val(result.info.url);
                    } else {
                        if (error && error.statusText) {
                            alert(error.statusText);
                        }
                    }
                }
            )
        })
    })
</script>
