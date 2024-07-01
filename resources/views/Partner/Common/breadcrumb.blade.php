<!-- BEGIN Breadcrumb -->
@php
    $deputy_headquarters_url = route('admin.partner.indexLevel', [
        'level_type' => config('constant_view.PAGE_PARTNER.deputy_headquarters.key'),
    ]);
    $deputy_headquarters_title = config('constant_view.PAGE_PARTNER.deputy_headquarters.title');
    $distributor_url = route('admin.partner.indexLevel', [
        'level_type' => config('constant_view.PAGE_PARTNER.distributor.key'),
    ]);
    $distributor_title = config('constant_view.PAGE_PARTNER.distributor.title');
    $agency_url = route('admin.partner.indexLevel', ['level_type' => config('constant_view.PAGE_PARTNER.agency.key')]);
    $agency_title = config('constant_view.PAGE_PARTNER.agency.title');
@endphp

<div class="panel-heading p-b-13 el-row breadcrumbs">
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
    <div class="panel-heading-btn-page align-right">
        <form action="{{ route('admin.partner.index') }}">
            @if(url()->current() == route('admin.partner.index'))
                <div class="btn-group mr-3">
                    <div class="input-daterange h-33 bg-input">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <input id="js__single-start-date" name="start_date" value="{{ request('start_date') }}" type="text" placeholder="검색시작날짜" class="el-range-input h-31">
                        <span class="el-range-separator">To</span>
                        <input id="js__single-end-date" name="end_date" value="{{ request('end_date') }}" type="text" placeholder="검색마지막날짜" class="el-range-input h-31">
                    </div>
                </div>
                <div class="btn-group">
                    <input placeholder="검색어입력" type="text" class="form-control input-sm width-200 search-input-box h-33 p-l-5 text-white" name="input_search" value="{{ request("input_search") }}">
                </div>
            @endif
            <div class="btn-group">
                <a href="{{route('partner.manager.index')}}" @class(['btnstyle1-success' => url()->current() == route('partner.manager.index'), 'btnstyle1 height-30  btnstyle1-inverse2'])>
                    파트너 트리
                </a>
                <a href="#" @class(['btnstyle1-success' => url()->current() == $deputy_headquarters_url, 'btnstyle1 height-30  btnstyle1-inverse2'])>
                    {{ $deputy_headquarters_title }}
                </a>
                <a href="#" @class(['btnstyle1-success' => url()->current() == $distributor_url, 'btnstyle1 height-30  btnstyle1-inverse2'])>
                    {{ $distributor_title }}
                </a>
                <a href="#" @class(['btnstyle1-success' => url()->current() == $agency_url, 'btnstyle1 height-30  btnstyle1-inverse2'])>
                    {{ $agency_title }}
                </a>
            </div>
        </form>
    </div>
    <h4 class="panel-title m-5 text-light">
        <strong><i class="{{ $icon ?? 'fa fa-arrow-down' }}"></i>
            @php
                $page = isset($page) ? $page . ' :: ' : '';
            @endphp
            {{ $page }} {{ $title ?? '' }}
        </strong>
    </h4>
</div>
