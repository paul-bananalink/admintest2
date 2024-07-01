<div @if (!empty($border)) style="border: 10px solid rgb(0, 0, 0);" @endif
    class="panel-heading p-b-13 el-row breadcrumbs">
    <div class="panel-heading-btn">
        <div class="btn-group m-l-1 m-r-2">
            {{-- <button type="button" onfocus="blur()"
                class="btnstyle1 btnstyle1-sm height-30 btnstyle1-success">기본환경설정</button>
            <button type="button" onfocus="blur()"
                class="btnstyle1 btnstyle1-sm height-30 btnstyle1-inverse2">입금설정</button> --}}
            @if (isset($action))
                @include($action)
            @endif
        </div>
    </div>
    @if (isset($form))
        @include($form, $form_params ?? [])
    @endif
    <h4 class="panel-title m-5 text-light">
        <strong><i class="{{ $icon ?? 'fa fa-arrow-down' }}"></i>
            @php
                $page = isset($page) ? $page . ' :: ' : '';
            @endphp
            {{ $page }} {{ $title ?? '' }}
        </strong>
    </h4>
</div>
