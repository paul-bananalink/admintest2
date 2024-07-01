@php $size = $size ?? '' @endphp
@php $uniqid = uniqid() @endphp
@php $className = $className ?? 'btn-toggle' @endphp

@if ($size == 'big')
    <style>
        .onoffswitch-{{ $id ?? $name ?? $uniqid }}-inner:before {
            content: "{{ $content ?? 'ON' }}";
            background-color: #244893;
            color: #fff;
            text-align: center;
        }

        .onoffswitch-{{ $id ?? $name ?? $uniqid }}-inner:after {
            content: "{{ $contentOff ?? 'OFF' }}";
            background-color: #903;
            color: #fff;
            text-align: center;
        }
    </style>

    <div class="toggle-switch-box height-33 text-light p-0 p-t-3"
        style="{{ isset($width) ? 'width: ' . $width : 'width: 100%' }}">
        <div class="onoffswitch width-full m-0 p-0">
            <input type="checkbox" data-gpcode="{{ $gpCode ?? '' }}" name="{{ $name ?? $uniqid }}" value="{{ $value ?? '' }}"
                name="onoffswitch" id="{{ $id ?? $name ?? $uniqid }}"
                class="onoffswitch-checkbox m-0 p-0 @if (!isset($offToggle)) btn-toggle @endif"
                url_action="{{ $urlAction ?? url()->current() }}" style="height: 27px;" @checked($isCheck ?? false)>
            <label for="{{ $id ?? $name ?? $uniqid }}" class="onoffswitch-label m-0 p-0">
                <span class="onoffswitch-inner onoffswitch-{{ $id ?? $name ?? $uniqid }}-inner"></span>
            </label>
        </div>
    </div>
@elseif ($size == 'normal')
    <style>
        .onoffswitch-{{ $id ?? $name }}-inner:before {
            content: "ON";
            padding-left: 5px;
            background-color: #34a7c1;
            color: #fff;
            text-align: left;
        }

        .onoffswitch-{{ $id ?? $name }}-inner:after {
            content: "OFF";
            padding-right: 5px;
            background-color: #333;
            color: red;
            text-align: right;
        }
    </style>
    <div class="toggle-switch-box text-light p-0"
        style="{{ isset($width) ? 'width: ' . $width : '100%' }}">
        <div class="onoffswitch width-full m-0 p-0">
            <input type="checkbox" data-gpcode="{{ $gpCode ?? '' }}" name="{{ $name ?? '' }}" value="{{ $value ?? '' }}"
                name="onoffswitch" id="{{ $id ?? $name }}"
                class="onoffswitch-checkbox m-0 p-0 @if (!isset($offToggle)) btn-toggle @endif"
                url_action="{{ $urlAction ?? url()->current() }}" style="height: 27px;" @checked($isCheck ?? false)>
            <label for="{{ $id ?? $name }}" class="onoffswitch-label m-0 p-0">
                <span class="onoffswitch-inner onoffswitch-{{ $id ?? $name }}-inner"></span>
                <span class="onoffswitch-switch"></span>
            </label>
        </div>
    </div>
@else
    <div class="flex-center">
        @if(!empty($left))
            <label class="content left">{{ $content }}</label>
        @endif
        <label class="switch">
            <input data-gpcode="{{ $gpCode ?? '' }}" @if (!isset($offToggle)) class="{{$className}}" @endif
                name="{{ $name ?? '' }}" value="{{ $value ?? '' }}"
                @if (isset($id)) id="{{ $id }}" @endif type="checkbox"
                url_action="{{ $urlAction ?? url()->current() }}" @if(isset($dataId)) data-id="{{ $dataId }}" @endif @checked($isCheck ?? false)>
            <span class="slider round"></span>
        </label>
        @if(empty($left))
            @isset($content)
                <label style="margin-left: 15px; margin-top: 0" class="content">{{ $content }}</label>
            @endisset
        @endif
    </div>
@endif
