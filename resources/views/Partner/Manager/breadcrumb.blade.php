{{-- <!-- BEGIN Breadcrumb -->
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

<div id="breadcrumbs">
    <ul class="breadcrumb cst_breadcrumb">
        <div class="row">
            <div class="col-md-4 p-5-10 breadcrumb-partner">
                <ul>
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{ route('partner.dashboard.index') }}">Home</a>
                        <span class="divider"><i class="fa fa-angle-right"></i></span>
                    </li>
                    @if (isset($breadcrumbs))
                        @foreach ($breadcrumbs as $index => $breadcrumb)
                            <li class="active">
                                @if (isset($breadcrumb['href']))
                                    <a href="{{ $breadcrumb['href'] }}">
                                @endif{{ $breadcrumb['title'] }}</a>
                            </li>
                            @if (count($breadcrumbs) !== $index + 1)
                                <span class="divider"><i class="fa fa-angle-right"></i></span>
                            @endif
                        @endforeach
                    @else
                        <li class="active">{{ $title }}</li>
                    @endif
                </ul>
            </div>
            <div class="col-md-8 text-right right-button">
                <a href="{{ route('partner.manager.index') }}" @class([
                    'btn-inverse' => url()->current() == route('partner.manager.index'),
                    'btn btn-sm btn-info',
                ])>
                    파트너 트리
                </a>

                @if ($data?->pType == 'deputy_headquarters')
                    <a href="#" @class([
                        'btn-inverse' => url()->current() == $deputy_headquarters_url,
                        'btn btn-sm btn-info',
                    ])>
                        {{ $deputy_headquarters_title }}
                    </a>
                    <a href="#" @class([
                        'btn-inverse' => url()->current() == $distributor_url,
                        'btn btn-sm btn-info',
                    ])>
                        {{ $distributor_title }}
                    </a>
                    <a href="#" @class([
                        'btn-inverse' => url()->current() == $agency_url,
                        'btn btn-sm btn-info',
                    ])>
                        {{ $agency_title }}
                    </a>
                @elseIf($data?->pType == 'distributor')
                    <a href="#" @class([
                        'btn-inverse' => url()->current() == $distributor_url,
                        'btn btn-sm btn-info',
                    ])>
                        {{ $distributor_title }}
                    </a>
                    <a href="#" @class([
                        'btn-inverse' => url()->current() == $agency_url,
                        'btn btn-sm btn-info',
                    ])>
                        {{ $agency_title }}
                    </a>
                @elseIf($data?->pType == 'agency')
                    <a href="#" @class([
                        'btn-inverse' => url()->current() == $agency_url,
                        'btn btn-sm btn-info',
                    ])>
                        {{ $agency_title }}
                    </a>
                @endif
            </div>
        </div>

    </ul>
</div> --}}

