<a href="{{ route('admin.page-setting.index') }}" @class([
    'btnstyle1-success' =>
        url()->current() == route('admin.page-setting.index'),
    'btnstyle1 height-30 btnstyle1-inverse2',
])>
    사이트운영 설정
</a>
{{-- <a href="{{route('admin.page-setting.manager-banner.index', ['type' => request('type', 'logo')])}}" @class(['btnstyle1-success' => url()->current() == route('admin.page-setting.manager-banner.index', ['type' => request('type', 'logo')]), 'btnstyle1 height-30 btnstyle1-inverse2'])>
    배너관리
</a><!-- manager banner --> --}}
<a href="{{ route('admin.page-setting.recharge-config.index') }}" @class([
    'btnstyle1-success' =>
        url()->current() == route('admin.page-setting.recharge-config.index'),
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    입금설정
</a><!-- Withdraw -->
<a href="{{ route('admin.page-setting.withdraw-config.index') }}" @class([
    'btnstyle1-success' =>
        url()->current() == route('admin.page-setting.withdraw-config.index'),
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    출금설정
</a> <!-- Withdraw -->

{{-- <a href="{{route('admin.page-setting.block-ip')}}" @class(['btnstyle1-success' => url()->current() == route('admin.page-setting.block-ip'), 'btnstyle1 height-30  btnstyle1-inverse2'])>
    아이피 차단
</a> --}}
<a href="{{ route('admin.page-setting.bonus-config.indexBonus') }}" @class([
    'btnstyle1-success' => request()->is('admin/page-setting/bonus-config/bonus*'),
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    지급포인트설정
</a>

@php
if(request()->is('admin/page-setting/sport-config/*') || 
    request()->is('admin/page-setting/realtime-config/*') || 
    request()->is('admin/page-setting/game-config/*') || 
    request()->is('admin/page-setting/virtual-sport-config/*') || 
    request()->is('admin/page-setting/casino-config/*')
)
{
    $actived_sport_config = true;
}
@endphp
<a href="{{ route('admin.page-setting.sport-config.index') }}" @class([
    'btnstyle1-success' => $actived_sport_config ?? false,
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    게임별읍선설정
</a>

<a href="{{ route('admin.page-setting.template.index') }}" @class([
    'btnstyle1-success' => in_array(url()->current(), [
        route('admin.page-setting.template.index'),
    ]),
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    쪽지답변설정
</a>

<a href="{{ route('admin.page-setting.auto-reply.index') }}" @class([
    'btnstyle1-success' => in_array(url()->current(), [
        route('admin.page-setting.auto-reply.index'),
    ]),
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    자동답변설정
</a>
<a href="#" @class([
    'btnstyle1-success' => in_array(url()->current(), []),
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    알람음설정
</a>
<a href="{{ route('admin.page-setting.domain.indexDomain') }}" @class([
    'btnstyle1-success' =>
        url()->current() == route('admin.page-setting.domain.indexDomain'),
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    사이드관리
</a>

<a href="{{ route('admin.page-setting.exchange-rate.indexExchangeRate') }}" @class([
    'btnstyle1-success' =>
        url()->current() ==
        route('admin.page-setting.exchange-rate.indexExchangeRate'),
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    환수률관리
</a>
<a href="{{ route('admin.page-setting.display.index') }}" @class([
    'btnstyle1-success' => in_array(url()->current(), [
        route('admin.page-setting.display.index'),
        route('admin.page-setting.display.index'),
    ]),
    'btnstyle1 height-30  btnstyle1-inverse2',
])>
    디자인설정
</a>
