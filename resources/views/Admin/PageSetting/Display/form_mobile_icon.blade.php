@php
    $i = $i ?? uniqid();
@endphp
<div class="mobile-item border-item text-center">
    <select class="form-control mb-12" name="mobile_icons[{{ $i }}][key]" data-placeholder="" tabindex="1">
        @foreach (config('site_config.MENU_LIST') as $key => $value)
            <option @selected(!empty($icon) && $icon['key'] == $key) value="{{ $key }}">
                {{ $value }}</option>
        @endforeach
    </select>
    <div id="mobile-icons-{{ $i }}" table="mobile-icons" class="fileupload upload-zone"
        data-provides="fileupload" data-no="{{ $i }}">
        <div id="mobile-icons-fileupload-preview-{{ $i }}"
            class="fileupload-preview fileupload-exists img-thumbnail">
            @if (!empty($icon['image']))
                <img src="{{ formatImageUrlApi($icon['image']) }}" alt="">
            @else
                <i class="fa fa-plus"></i>
            @endif
        </div>
        <input type="hidden" class="mobile-icons-image-upload-{{ $i }}"
            name="mobile_icons[{{ $i }}][image]" value="{{ $icon['image'] ?? '' }}">
    </div>
</div>
