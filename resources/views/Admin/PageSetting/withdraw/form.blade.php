<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.page-setting.withdraw-config.store') }}" method="POST"
            id="page_setting_withdraw_index">
            @csrf
            <div class="box">
                <div class="box-content">
                    <div class="tools-bar mt-12">
                        <div class="float-left">
                            <strong class="form-title"><i class="fa fa-cog"></i> 출금설정</strong>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btnstyle1 btnstyle1-success h-31"> <i class="fa fa-cog"></i>
                                설졍값저장
                            </button>
                        </div>
                    </div>

                    <div class="col-md-12 m-0 p-0">
                        @if (session('success'))
                            <div class="alert alert-success m-t-10">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->hasBag('withdraw-setting'))
                            @foreach ($errors->getBag('withdraw-setting')->all() as $error)
                                <div class="alert alert-warning m-t-10" role="alert">{{ $error }}</div>
                            @endforeach
                        @endif
                        <div class="col-md-12 p-0">
                            <div class="col-md-3 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>1회 최소 환전금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        환전당 최소금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="wcMinWithdraw"
                                                value="{{ number_format($withdraw_config->wcMinWithdraw) }}"
                                                placeholder="환전당 최소금액">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>재 환전(출금) 시간차</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        회원의 잦은 환전 요청을 방지를 위한 시간차 설정 / 자정에 초기화여부
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <div class="col-md-6">
                                                <input
                                                    class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                    type="text" min="0" name="wcDelayTime"
                                                    value="{{ $withdraw_config->wcDelayTime }}" placeholder="시간차">
                                            </div>
                                            <div class="col-md-6">
                                                <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                    isCheck="{{ $withdraw_config->wcEnableDelayTime }}"
                                                    id="wcEnableDelayTime"
                                                    urlAction="{{ route('admin.page-setting.withdraw-config.toggle-field', ['field' => 'wcEnableDelayTime']) }}"
                                                    size="big" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>자동 롤링계산 여부</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        자동으로 콜링계산를 하는가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $withdraw_config->wcAutoPayRoll }}" id="wcAutoPayRoll"
                                                urlAction="{{ route('admin.page-setting.withdraw-config.toggle-field', ['field' => 'wcAutoPayRoll']) }}"
                                                size="big" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>보너스 미선택시 콜링규정</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        보너스 미선택시 콜링규정
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                type="text" name="wcNoBonusContent"
                                                value="{{ $withdraw_config->wcNoBonusContent }}"
                                                placeholder="보너스 미선택시 콜링규정">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-0">
                            <div class="col-md-3 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>출금액 수동입력 여부</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        출금액 수동입력이 가능한가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $withdraw_config->wcManualWithdraw }}"
                                                id="wcManualWithdraw"
                                                urlAction="{{ route('admin.page-setting.withdraw-config.toggle-field', ['field' => 'wcManualWithdraw']) }}"
                                                size="big" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>출금신청 관리</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        자정에 출금이 가능한가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <div class="col-md-4 pl-10 pr-10">
                                                <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                    isCheck="{{ $withdraw_config->wcEnableTimeOffWithdraw }}"
                                                    id="wcEnableTimeOffWithdraw"
                                                    urlAction="{{ route('admin.page-setting.withdraw-config.toggle-field', ['field' => 'wcEnableTimeOffWithdraw']) }}"
                                                    size="big" />
                                            </div>
                                            <div class="col-md-8 d-flex items-center pl-10 pr-10">
                                                <span>23 : </span>
                                                <span class="ml-4"><input name="minutes[start]"
                                                        value="{{ parseMinutes($withdraw_config->wcTimeOffWithdraw)['start_time'] ?? '' }}"
                                                        class="form-control search-input-box height-33 text-white2 p-5 width-50"
                                                        min="0" max="59" type="number"></span>
                                                <span class="ml-4 mr-4">부터 ~ 00: </span>
                                                <span><input name="minutes[end]"
                                                        value="{{ parseMinutes($withdraw_config->wcTimeOffWithdraw)['end_time'] ?? '' }}"
                                                        class="form-control search-input-box height-33 text-white2 p-5 width-50"
                                                        min="0" max="59" type="number">
                                                </span>
                                                <span class="ml-4">까지 점검</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>출금가능여부 설정</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        출금이 가능한가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $withdraw_config->wcEnableWithdraw }}"
                                                id="wcEnableWithdraw"
                                                urlAction="{{ route('admin.page-setting.withdraw-config.toggle-field', ['field' => 'wcEnableWithdraw']) }}"
                                                size="big" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>출금차단 시 멘트</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        멘트내용
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                type="text" min="0" name="wcDisableWithdrawContent"
                                                value="{{ $withdraw_config->wcDisableWithdrawContent }}"
                                                placeholder="멘트내용">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-0">
                            <div class="col-md-12 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>1회 최대 환전금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        환전당 최대금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17 d-flex">
                                            @foreach (config('site_config.LEVELS') as $level)
                                                <input placeholder="Level {{ $level }}"
                                                    value="{{ formatNumber($withdraw_config->wcMaxRechargePerTime[$level] ?? '') }}"
                                                    name="wcMaxRechargePerTime[{{ $level }}]" type="text"
                                                    class="form-control">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-3">
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>1일 최대 환전금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        일 최대금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17 d-flex">
                                            @foreach (config('site_config.LEVELS') as $level)
                                                <input placeholder="Level {{ $level }}"
                                                    value="{{ formatNumber($withdraw_config->wcMaxRechargePerDay[$level] ?? '') }}"
                                                    name="wcMaxRechargePerDay[{{ $level }}]" type="text"
                                                    class="form-control">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tools-bar">
                        <div class="float-left pb-10 pt-10">
                            <strong class="form-title"><i class="fa fa-cog"></i> 롤링요율설정</strong>
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-0">
                        <div class="col-md-12 p-0">
                            <div class="col-md-8 p-3">
                                <table class="table table-bordered cst-table-darkbrown mt-12">
                                    <thead>
                                        <th></th>
                                        <th>스포츠 단폴</th>
                                        <th>실시간 단폴</th>
                                        <th>스포츠 다폴</th>
                                        <th>실시간 다폴</th>
                                        <th>미니게임</th>
                                        <th>가상 스포츠</th>
                                        <th>파싱카지노</th>
                                        <th>카지노</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>보너스 없음</td>
                                            @foreach (config('site_config.WITHDRAW.ROLLING_SETTING.BET_TYPES')['first'] as $name => $betType)
                                                <td>
                                                    <input value="{{ $withdraw_config->wcNoBonus[$name] ?? '' }}"
                                                        type="text" class="form-control"
                                                        name="wcNoBonus[{{ $name }}]">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>보너스 받음</td>
                                            @foreach (config('site_config.WITHDRAW.ROLLING_SETTING.BET_TYPES')['first'] as $name => $betType)
                                                <td>
                                                    <input value="{{ $withdraw_config->wcBonus[$name] ?? '' }}"
                                                        type="text" class="form-control"
                                                        name="wcBonus[{{ $name }}]">
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4 p-3">
                                <table class="table table-bordered cst-table-darkbrown mt-12">
                                    <thead>
                                        <tr>
                                            <th>포커</th>
                                            <th>핸드수</th>
                                            <th>롤링요율</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>보너스 없음</td>
                                            @foreach (config('site_config.WITHDRAW.ROLLING_SETTING.BET_TYPES')['seconds'] as $name => $betType)
                                                <td>
                                                    <input value="{{ $withdraw_config->wcNoBonus[$name] ?? '' }}"
                                                        type="text" class="form-control"
                                                        name="wcNoBonus[{{ $name }}]">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>보너스 받음</td>
                                            @foreach (config('site_config.WITHDRAW.ROLLING_SETTING.BET_TYPES')['seconds'] as $name => $betType)
                                                <td>
                                                    <input value="{{ $withdraw_config->wcBonus[$name] ?? '' }}"
                                                        type="text" class="form-control"
                                                        name="wcBonus[{{ $name }}]">
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tools-bar">
                        <div class="float-left pb-10 pt-10">
                            <strong class="form-title"><i class="fa fa-cog"></i> 출금규정설정</strong>
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-0">
                        <div class="col-md-12 p-0">
                            <div class="col-md-12 p-3">
                                <textarea name="wcRuleWithdrawContent" rows="5" class="form-control js__editor width-full">{!! $withdraw_config->wcRuleWithdrawContent !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@section('custom-js')
    @vite(['resources/vite/js/page_setting/format_money.js', 'resources/vite/js/page_setting/withdraw_config.js'])
@endsection
