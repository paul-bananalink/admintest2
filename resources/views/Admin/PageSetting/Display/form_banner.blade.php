@php
    $i = $i ?? uniqid();
@endphp
<div class="text-center border-item">
    <select class="form-control mb-12" name="banner[{{ $i }}][target]" tabindex="1">
        @foreach (config('site_config.TARGET') as $key => $value)
            <option @selected(!empty($banner) && $banner['target'] == $key) value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
    <input type="text" class="form-control mr-2 mb-12" name="banner[{{ $i }}][link]"
        value="{{ $banner['link'] ?? '' }}" placeholder="내용 검색" />
    <div id="banner-{{ $i }}" table="banner" class="fileupload upload-zone banner" data-provides="fileupload"
        data-no="{{ $i }}">
        <div id="banner-fileupload-preview-{{ $i }}"
            class="fileupload-preview fileupload-exists img-thumbnail">
            @if (!empty($banner['image']))
                <img style="max-width: 150px; max-height: 150px; object-fit: cover;"
                    src="{{ formatImageUrlApi($banner['image']) }}" alt="">
            @else
                <i class="fa fa-plus"></i>
            @endif
        </div>
        <input type="hidden" class="banner-image-upload-{{ $i }}" name="banner[{{ $i }}][image]"
            value="{{ $banner['image'] ?? '' }}">
    </div>
</div>
