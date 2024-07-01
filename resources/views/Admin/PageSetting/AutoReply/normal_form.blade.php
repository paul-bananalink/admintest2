@php
    $rand = rand(100, 10000);
    $arLevel = $type->arLevel ?? null;
@endphp
<div class="col-md-2 p-10 panel-auto-reply mr-4 mb-12 template-item">
    <button class="btnstyle1 btnstyle1-inverse4 h-33 cancel-btn float-right remove-template"><i class="fa fa-close"></i>
    </button>
    <input type="hidden" value="{{ $type->arNo ?? null }}" name="data[{{ $type->arNo ?? $rand }}][arNo]">
    <input value="2" type="hidden" class="form-type" name="data[{{ $type->arNo ?? $rand }}][arType]">
    <div class="col-md-8 p-0 mb-4">
        <input value="{{ $type->arLink ?? '' }}" name="data[{{ $type->arNo ?? $rand }}][arLink]" type="text"
            class="form-control width-full form-link">
    </div>
    <div class="col-md-12 p-0 mb-4 text-edit-h-280">
        <textarea style="overflow-y: auto" class="width-full p-10 form-desc js__editor"
            name="data[{{ $type->arNo ?? $rand }}][arContent]" id="" cols="20" rows="10">{!! $type->arContent ?? '' !!}</textarea>
    </div>
    {{-- <div class="col-md-12 p-0 mb-4">
        <button class="btnstyle1 btnstyle1-success h-31 width-full btn-open-modal">내용수정</button>
    </div> --}}
</div>
