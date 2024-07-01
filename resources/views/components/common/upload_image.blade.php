{{-- params[
    $index, $imageUrl, $name
] --}}

@php
    $style = '';
    if(!empty($width)) {
        $style .= 'width: '.$width.'px;';
    }
    if(!empty($height)) {
        $style .= 'height: '.$height.'px;';
    }

    $showDelete = $showDelete ?? false;
@endphp

@if($showDelete)
    
    <div class="relative">
        <div id="image-upload-{{ $index ?? 'single' }}" class="upload_image m-auto" data-provides="fileupload" data-index="{{ $index ?? 'single' }}" style="{{ $style }}">
            <div id="fileupload-preview-{{ $index ?? 'single' }}"
                class="fileupload-preview fileupload-exists image-file h-full">
                @if (!empty($imageUrl))
                    <img src="{{ getImageUrl($imageUrl) }}" class="image-file">
                @endif
            </div>
            <input type="hidden" class="image_upload_{{ $index ?? 'single' }}"
                name="{{ $name ?? '' }}"
                value="{{ $imageUrl ?? '' }}">
        </div>
        <a class="delete_image" data-id="{{$index}}"><i class="fa fa-close"></i></a>
    </div>
@else
    <div id="image-upload-{{ $index ?? 'single' }}" class="upload_image m-auto" data-provides="fileupload" data-index="{{ $index ?? 'single' }}" style="{{ $style }}">
        <div id="fileupload-preview-{{ $index ?? 'single' }}"
            class="fileupload-preview fileupload-exists image-file h-full">
            @if (!empty($imageUrl))
                <img src="{{ getImageUrl($imageUrl) }}" class="image-file">
            @endif
        </div>
        <input type="hidden" class="image_upload_{{ $index ?? 'single' }}"
            name="{{ $name ?? '' }}"
            value="{{ $imageUrl ?? '' }}">
    </div>
@endif
