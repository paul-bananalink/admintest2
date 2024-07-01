<div class="row">
    <div class="col-md-12">
        <div class="box">
            <form action="{{ route('admin.page-setting.recharge-config.store') }}" method="POST"
                id="page_setting_recharge_index">
                @csrf
                <div class="box-content">
                    <div class="tools-bar mt-12">
                        <div class="float-left">
                            <strong class="form-title"><i class="fa fa-cog"></i> 입금설졍</strong>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btnstyle1 btnstyle1-success h-31"> <i class="fa fa-cog"></i>
                                설졍값
                                저장</button>
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-0">
                        @if (session('success'))
                            <div class="alert alert-success m-t-10">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->hasBag('recharge-config'))
                            @foreach ($errors->getBag('recharge-config')->all() as $error)
                                <div class="alert alert-warning m-t-10" role="alert">{{ $error }}</div>
                            @endforeach
                        @endif
                        <div class="col-md-12 p-0">
                            <div class="col-md-3 p-3">
                                <!-- Name -->
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>스포츠 첫충 보너스 최대 금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        스포츠 첫충 보너스 지급액의 최대금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="rcMaxBonusFirstTimeSportsRecharge"
                                                value="{{ number_format($recharge_config->rcMaxBonusFirstTimeSportsRecharge) }}"
                                                placeholder="직접 입력">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <!-- Name -->
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>스포츠 매충 보너스 최대금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        스포츠 매충 보너스 지급액의 최대금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="rcMaxBonusSportsRecharge"
                                                value="{{ number_format($recharge_config->rcMaxBonusSportsRecharge) }}"
                                                placeholder="직접 입력">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <!-- Name -->
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>카지노 첫충 보너스 최대 금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        카지노 첫충 보너스 지급액의 최대금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="rcMaxBonusFirstTimeCasinoRecharge"
                                                value="{{ number_format($recharge_config->rcMaxBonusFirstTimeCasinoRecharge) }}"
                                                placeholder="직접 입력">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <!-- Name -->
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>카지노 매층 보너스 최대금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        카지노 매충 보너 지급액의 최대 금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="rcMaxBonusFirstTimePokerRecharge"
                                                value="{{ number_format($recharge_config->rcMaxBonusFirstTimePokerRecharge) }}"
                                                placeholder="직접 입력">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <!-- Name -->
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>포커 첫층 보너스 최대 금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        포커 첫충 보너스
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="rcMaxBonusPokerRecharge"
                                                value="{{ number_format($recharge_config->rcMaxBonusPokerRecharge) }}"
                                                placeholder="직접 입력">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <!-- Name -->
                                <div
                                    class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                    <div class="col-md-12 p-0 text-center">
                                        <div class="bg-black-2 col-md-12 text-right">
                                            <div class="pull-left m-t-10 text-left">
                                                <div>
                                                    <span class="f-s-15 m-l-4">
                                                        <strong>포커 매층 보너스 최대금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        포커 매충 보너스 지급학의 최대금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="rcMaxBonusCasinoRecharge"
                                                value="{{ number_format($recharge_config->rcMaxBonusCasinoRecharge) }}"
                                                placeholder="직접 입력">
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
                                                        <strong>포커 첫층 보너스 최대 금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        포커 첫충 보너스
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="rcMaxBonusFirstTimePokerRecharge"
                                                value="{{ number_format($recharge_config->rcMaxBonusFirstTimePokerRecharge) }}"
                                                placeholder="직접 입력">
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
                                                        <strong>포커 매층 보너스 최대금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        포커 매충 보너스 지급학의 최대금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="rcMaxBonusPokerRecharge"
                                                value="{{ number_format($recharge_config->rcMaxBonusPokerRecharge) }}"
                                                placeholder="직접 입력">
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
                                                        <strong>보너스 제한 금액기준</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        보유금액이 기준이상이면 보너스 선택 불가
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5 formatMoney"
                                                type="text" min="0" name="rcAmountNoBonus"
                                                value="{{ number_format($recharge_config->rcAmountNoBonus) }}"
                                                placeholder="직접 입력">
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
                                                        <strong>입금 재신청 시간</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        입금 승인처리 후 몇초 후 재입금 신청 가능한가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                type="text" min="0" name="rcDelayTime"
                                                value="{{ number_format($recharge_config->rcDelayTime) }}"
                                                placeholder="직접 입력">
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
                                                        <strong>입금보너스 자동선택</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        입금페이지에서 입금보너스가 자동으로 선택되는가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $recharge_config->rcAutoBonus }}" id="rcAutoBonus"
                                                urlAction="{{ route('admin.page-setting.recharge-config.toggle-field', ['field' => 'rcAutoBonus']) }}"
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
                                                        <strong>입금액 수동입력 여부</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        입금액 수동입력이 가능한가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $recharge_config->rcManualRecharge }}"
                                                urlAction="{{ route('admin.page-setting.recharge-config.toggle-field', ['field' => 'rcManualRecharge']) }}"
                                                id="rcManualRecharge" size="big" />
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
                                                        <strong>입금신청 관리</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        자정에 입금이 가능한가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <div class="col-md-4 pl-10 pr-10">
                                                <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                    isCheck="{{ $recharge_config->rcEnableTimeOffRecharge }}"
                                                    id="rcEnableTimeOffRecharge"
                                                    urlAction="{{ route('admin.page-setting.recharge-config.toggle-field', ['field' => 'rcEnableTimeOffRecharge']) }}"
                                                    size="big" />
                                            </div>
                                            <div class="col-md-8 d-flex items-center pl-10 pr-10">
                                                <span>23 : </span>
                                                <span class="ml-4"><input name="minutes[start]"
                                                        value="{{ parseMinutes($recharge_config->rcTimeOffRecharge)['start_time'] ?? '' }}"
                                                        class="form-control search-input-box height-33 text-white2 p-5 width-50"
                                                        min="0" max="59" type="number"></span>
                                                <span class="ml-4 mr-4">부터 ~ 00: </span>
                                                <span><input name="minutes[end]"
                                                        value="{{ parseMinutes($recharge_config->rcTimeOffRecharge)['end_time'] ?? '' }}"
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
                                                        <strong>최소 입금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        입금가능한 최소금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                type="text" min="0" name="rcMinRecharge"
                                                value="{{ number_format($recharge_config->rcMinRecharge) }}"
                                                placeholder="직접 입력">
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
                                                        <strong>입금보너스 설정</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        진행중인 배팅이 있을 경우 입금 보너스 선택이 가능한가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="선택가능" contentOff="선택불가능"
                                                isCheck="{{ $recharge_config->rcEnableConfigBonus }}"
                                                id="rcEnableConfigBonus"
                                                urlAction="{{ route('admin.page-setting.recharge-config.toggle-field', ['field' => 'rcEnableConfigBonus']) }}"
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
                                                        <strong>입금가능여부 설정</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        입금이 가능한가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $recharge_config->rcEnableRecharge }}"
                                                urlAction="{{ route('admin.page-setting.recharge-config.toggle-field', ['field' => 'rcEnableRecharge']) }}"
                                                id="rcEnableRecharge" size="big" />
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
                                                        <strong>입금차단 시 멘트</strong>
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
                                                type="text" name="rcDisableRechargeContent"
                                                value="{{ $recharge_config->rcDisableRechargeContent }}"
                                                placeholder="직접 입력">
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
                                                        <strong>천원 입금버튼 사용여부</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        천원 입금버튼를 사용하는가?
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                                isCheck="{{ $recharge_config->rcEnableThousandMoney }}"
                                                urlAction="{{ route('admin.page-setting.recharge-config.toggle-field', ['field' => 'rcEnableThousandMoney']) }}"
                                                id="rcEnableThousandMoney" size="big" />
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
                                                        <strong>1회 최대 충전금액</strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="f-s-12 m-l-4 text-gray">
                                                        충전당 최대금액
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17 d-flex">
                                            @foreach (config('site_config.LEVELS') as $level)
                                                <input placeholder="Level {{ $level }}" type="text"
                                                    name="rcMaxRecharge[{{ $level }}]"
                                                    value="{{ formatNumber(data_get($recharge_config, "rcMaxRecharge.{$level}", '')) }}"
                                                    class="form-control">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tools-bar">
                        <div class="float-left pb-10 mt-20">
                            <strong class="form-title"><i class="fa fa-cog"></i> 입금보너스 주의멘트 설정</strong>
                        </div>
                    </div>
                    <table class="table table-bordered cst-table-darkbrown mt-12">
                        <thead>
                            <th class="width-200">
                                <button id="saveBonusWarningMessage" type="submit"
                                    class="btnstyle1 btnstyle1-success h-31 btn-submit"> <i class="fa fa-cog"></i>설정값
                                    저장
                                </button>
                            </th>
                            <th>보너스 없음</th>
                            <th>스포츠 첫충</th>
                            <th>카지노 첫충</th>
                            <th>스포츠 매충</th>
                            <th>카지노 매충</th>
                            <th>입플</th>
                            <th>신규</th>
                            <th>포커 보너스 없음</th>
                            <th>포커 첫충</th>
                            <th>포커 매충</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>주의 멘트</td>
                                @foreach (config('site_config.RECHARGE_BONUS_WARNING_MESSAGE') as $key => $value)
                                    <td><input attr-key="{{ $key }}"
                                            name="rcBonusWarningMessage[{{ $key }}]" type="text"
                                            value="{{ old('rcBonusWarningMessage.' . $key, $recharge_config->rcBonusWarningMessage[$key] ?? '') }}"
                                            class="form-control"></td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    <div class="tools-bar">
                        <div class="float-left pb-10">
                            <strong class="form-title"><i class="fa fa-cog"></i> 입금규정설졍</strong>
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-0">
                        <div class="col-md-12 p-0">
                            <textarea name="rcWarningRechargeContent" rows="5" class="form-control js__editor width-full">{!! $recharge_config->rcWarningRechargeContent !!}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-0">
                        <div class="col-md-3 p-3">
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>은행리스트</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    회원가입페이지 은행리스트
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <textarea name="rcBanks" rows="5" class="form-control width-full">{{ $recharge_config->rcBanks }}</textarea>
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
                                                    <strong>1:1계좌 안내 상단멘트</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    1:1계좌 안내 상단멘트
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <textarea name="rcInfoTopComment" rows="5" class="form-control width-full">{{ $recharge_config->rcInfoTopComment }}</textarea>
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
                                                    <strong>1:1계좌 안내 하단멘트</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    1:1계좌 안내 하단멘드
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <textarea name="rcInfoButtonComment" rows="5" class="form-control width-full">{{ $recharge_config->rcInfoButtonComment }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @section('custom-js')
        @vite(['resources/vite/js/page_setting/format_money.js', 'resources/vite/js/page_setting/recharge_config.js'])
    @endsection
