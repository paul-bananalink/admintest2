<div id="group-{{$type}}"
@class([
    'fileupload',
    'fileupload-exists' => data_get($site_info, $type, ''),
    'fileupload-new' => ! data_get($site_info, $type, ''),
])
data-provides="{{$type}}"
>
    <div class="fileupload-new img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">
        <img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" alt="image" style="max-width: 200px; max-height: 150px; line-height: 10px;">
    </div>
    <div id="preview-{{$type}}" class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">
        @if ($path = data_get($site_info, $type, ''))
            <img src="{{ asset($path) }}" alt="image" style="max-width: 200px; max-height: 150px; line-height: 10px;">
        @endif
    </div>
    <div>
        <span class="btn btn-default btn-file">
            <div class="image-select" data-id="{{$type}}">
            <span class="fileupload-new" >Select image</span>
            <span class="fileupload-exists">Change</span>
            </div>
            <input type="hidden" name="{{$type}}" value="{{ data_get($site_info, $type, '') }}">
        </span>
        <a href="#" class="btn btn-default fileupload-exists remove-image" data-id="{{$type}}" data-dismiss="fileupload">Remove</a>
    </div>
</div>
