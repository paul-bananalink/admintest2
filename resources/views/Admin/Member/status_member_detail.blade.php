@use('App\Models\Member')
@use('App\Models\MoneyInfo')

<div class="el-row">
    <div class="el-col el-col-24">
        <div class="m-15">
            <form id="member-config-form" method="POST"
                action="{{ route('admin.status-members.create-or-update-member') }}" data-id="{{ $member->mNo }}">
                @csrf
                <input type="hidden" name="mNo" id="mNo" value="{{ $member->mNo }}">
                <input type="hidden" name="mID" id="mID" value="{{ $member->mID }}">
                <table class="table table-bordered table-td-valign-middle text-center text-white no-bg m-0">
                    <tbody>
                        <tr>
                            <td class="text-center bg-black-darker6 w-80">차단</td>
                            <td class="text-center bg-black-darker p-0 w-200">
                                <div class="text-center width-full height-40 no-bg m-0 p-0 p-t-10 position-relative">
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $member->mStatus == Member::M_STATUS_EIGHT }}"
                                        id="mStatusBlock{{ $member->mNo }}" name="mStatus" dataId="{{ $member->mNo }}"
                                        urlAction="{{ route('admin.status-members.update-status-member', ['id' => $member->mNo, 'type' => 'block']) }}"
                                        offToggle="true" />
                                </div>
                            </td>
                            <td class="text-center bg-black-darker6 w-80">탈퇴</td>
                            <td class="text-center bg-black-darker p-0 w-200">
                                <div
                                    class="table-td-valign-middle text-center width-full height-40 no-bg m-0 p-0 p-t-10 position-relative">
                                    <x-common.toggle_switch_button isCheck="{{ $member->memberConfig->mcForceLogout }}"
                                        id="mcForceLogout{{ $member->mNo }}" name="mcForceLogout"
                                        dataId="{{ $member->mNo }}"
                                        urlAction="{{ route('admin.status-members.force-logout', ['id' => $member->mNo]) }}"
                                        offToggle="true" />
                                </div>
                            </td>
                            <td class="text-center bg-black-darker6 w-80">
                                전액출금
                            </td>
                            <td class="text-center bg-black-darker p-5 w-200">
                                <button type="button" data-id="{{ $member->mNo }}"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 width-full btn-withdraw-money">
                                    출금
                                </button>
                            </td>
                            <td class="text-center bg-black-darker6 w-80">
                                카지노회원
                            </td>
                            <td class="text-center bg-black-darker p-5 w-200">
                                <x-common.toggle_switch_button id="" name="" urlAction="" />
                            </td>
                            <td class="text-center bg-black-darker6 w-80">
                                양방의심
                            </td>
                            <td class="text-center bg-black-darker p-5 w-200">
                                <select class="form-control input-sm input-box width-full text-white"
                                    style="border: 1px solid rgb(49, 65, 91)" name="mcSuspicion">
                                    <option value="" class="p-5">관리자설정</option>
                                    <option value="일반회원" @selected($member->memberConfig->mcSuspicion === '일반회원') class="p-5">일반회원</option>
                                    @foreach (config('site_config.SUSPICION_LIST') as $item)
                                        <option value="{{ $item }}" @selected($member->memberConfig->mcSuspicion === $item)
                                            class="p-5">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center bg-black-darker6 w-80">
                                쿠폰관리
                            </td>
                            <td class="text-center bg-black-darker p-5 w-200">
                                <button type="button"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 pull-left m-r-10"
                                    style="width: calc(50% - 5px)">
                                    지급
                                </button>
                                <button type="button"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 pull-left"
                                    style="width: calc(50% - 5px)">
                                    내역
                                </button>
                            </td>
                            <td rowspan="8" class="text-center bg-black-darker6 p-5 w-80">
                                게임그래프
                            </td>
                            <td rowspan="8" class="text-center bg-black-darker p-5">
                                <div style="width: 200px; height: 150px">
                                    <div class="echarts" _echarts_instance_="ec_1716803088815"
                                        style="
                                      width: 200px;
                                      height: 150px;
                                      -webkit-tap-highlight-color: transparent;
                                      user-select: none;
                                      position: relative;
                                    ">
                                        <div
                                            style="
                                        position: relative;
                                        width: 200px;
                                        height: 150px;
                                        padding: 0px;
                                        margin: 0px;
                                        border-width: 0px;
                                      ">
                                            <canvas data-zr-dom-id="zr_0" width="200" height="150"
                                                style="
                                          position: absolute;
                                          left: 0px;
                                          top: 0px;
                                          width: 200px;
                                          height: 150px;
                                          user-select: none;
                                          -webkit-tap-highlight-color: rgba(
                                            0,
                                            0,
                                            0,
                                            0
                                          );
                                          padding: 0px;
                                          margin: 0px;
                                          border-width: 0px;
                                        "></canvas>
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                            </td>
                            <td rowspan="8" class="text-center bg-black-darker6 w-80">
                                간단메모
                            </td>
                            <td rowspan="8" class="text-center bg-black-darker p-5 w-200">
                                <textarea rows="4" name="mNote" id="mNote"
                                    class="form-control p-5 m-0 input-box width-full text-white m-0 m-t-15" style="height: 200px">{!! data_get($member, 'mNote', '') !!}</textarea>
                                <button type="button" data-toggle="collapse"
                                    data-target="#MEMBER_HISTORY{{ $member->mNo }}"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 m-t-10 width-full">
                                    상세보기
                                </button>
                            </td>
                            <td rowspan="8" class="text-center bg-black-darker2 p-1 p-l-5 p-r-5 w-50">
                                <button
                                    class="btnstyle1 btnstyle1-primary btnstyle1-sm height-115 width-25 text-white p-2">
                                    <i class="ion-checkmark"></i>저장하기
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center bg-black-darker6">
                                상위 파트너명
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" class="form-control input-sm input-box width-full text-white"
                                    name="mNamePartner" id="mNamePartner{{ $member->mNo }}"
                                    value="{{ $member->partner->mPartnerName ?? '' }}" readonly />
                            </td>
                            <td class="text-center bg-black-darker6">추천인</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" class="form-control input-sm input-box width-full text-white"
                                    name="mMemberID" id="mMemberID" value="{{ $member->mMemberID ?? '' }}" />
                            </td>
                            <td class="text-center bg-black-darker6">레벨</td>
                            <td class="text-center bg-black-darker p-5">
                                <select class="form-control input-sm input-box width-full text-white"
                                    style="border: 1px solid rgb(49, 65, 91)" name="mLevel">
                                    @foreach (config('site_config.LEVELS') as $level)
                                        <option value="{{ $level }}" class="p-5"
                                            @if ($level == $member->mLevel) selected @endif>
                                            레벨 {{ $level }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center bg-black-darker6">닉네임</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" class="form-control input-sm input-box width-full text-white"
                                    name="mNick" id="mNick" value="{{ $member->mNick ?? '' }}" />
                            </td>
                            <td class="text-center bg-black-darker6">
                                비밀번호
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" placeholder="#&amp;+ 사용불가" name="mPW"
                                    class="input-sm input-box width-full text-white" />
                            </td>
                            <td class="text-center bg-black-darker6">
                                전화번호
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mPhone" id="mPhone" placeholder="번호만 입력하세요"
                                    class="form-control input-sm input-box width-full text-white mPhone"
                                    value="{{ $member->mPhoneCom ? hashString($member->mPhone) : $member->mPhone }}" />
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center bg-black-darker6">은행</td>
                            <td class="text-center bg-black-darker p-5">
                                <select class="form-control input-sm input-box width-full text-white"
                                    style="border: 1px solid rgb(49, 65, 91)" name="mBankName" id="mBankName">
                                    @foreach ($bankList as $bank)
                                        <option value="{{ $bank }}" class="p-5"
                                            @if ($bank == $member->mBankName) selected @endif>
                                            {{ $bank }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center bg-black-darker6">
                                계좌번호
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mBankNumber" id="mBankNumber"
                                    class="form-control input-sm input-box width-full text-white"
                                    value="{{ $member->mBankNumber ?? '' }}" />
                            </td>
                            <td class="text-center bg-black-darker6">예금주</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mBankOwner" id="mBankOwner"
                                    class="form-control input-sm input-box width-full text-white"
                                    value="{{ $member->mBankOwner ?? '' }}" />
                            </td>
                            <td class="text-center bg-black-darker6">
                                롤링완료
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <div class="m-b-5 el-row">스포츠,카지노</div>
                                <div class="m-b-5 el-row">
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $member->memberConfig->mcSportsRolling ?? false }}"
                                        id="mcSportsRolling" name="mcSportsRolling"
                                        urlAction="{{ route('admin.member-config.update', ['field' => 'mcSportsRolling', 'mcNo' => $member->mID]) }}" />
                                </div>
                                <div class="m-b-5 el-row">카지노</div>
                                <div class="el-row">
                                    <x-common.toggle_switch_button
                                        isCheck="{{ $member->memberConfig->mcCasinoRolling ?? false }}"
                                        id="mcCasinoRolling" name="mcCasinoRolling"
                                        urlAction="{{ route('admin.member-config.update', ['field' => 'mcCasinoRolling', 'mcNo' => $member->mID]) }}" />
                                </div>
                            </td>
                            <td class="text-center bg-black-darker6">
                                자동답변
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <select class="form-control input-sm input-box width-full text-white"
                                    style="border: 1px solid rgb(49, 65, 91)">
                                    <option class="p-5" value="">
                                        사용하지 않음
                                    </option>
                                    <option class="p-5" value="6002b9dd2b38c122d8f616da">
                                        본사장 5%
                                    </option>
                                    <option class="p-5" value="60039aa22b38c122d8f62ec7">
                                        본사장 5%
                                    </option>
                                    <option class="p-5" value="60039aa62b38c122d8f62ec8">
                                        본사장 15%
                                    </option>
                                    <option class="p-5" value="60039f632b38c122d8f6343c">
                                        본사장 배팅 성향 불량
                                    </option>
                                    <option class="p-5" value="60039ff52b38c122d8f63470">
                                        본사장 15%
                                    </option>
                                    <option class="p-5" value="60b8b268df18e0daf9c6ce78">
                                        본사장 5% 배팅성향 불량
                                    </option>
                                    <option class="p-5" value="60f950cdcd8d651918bc46a6">
                                        pg사 인증 배팅불량
                                    </option>
                                    <option class="p-5" value="61ffb4fc09137144700922c4">
                                        pg사 신규 배팅불량
                                    </option>
                                    <option class="p-5" value="627fc6351b5aa95d406f9472">
                                        pg사 신규 15%
                                    </option>
                                    <option class="p-5" value="627fc6351b5aa95d406f9473">
                                        중복가입
                                    </option>
                                    <option class="p-5" value="627fc6391b5aa95d406f9477">
                                        pg사 신규 배팅불량
                                    </option>
                                    <option class="p-5" value="629278f8761202450c3aa7e3">
                                        계좌 변경 요청
                                    </option>
                                    <option class="p-5" value="63626c5dbdc8420b38a4f7be">
                                        pg사 인증 15%
                                    </option>
                                    <option class="p-5" value="658bacbf518b3015ace6c73d">
                                        pg사 인증 5%
                                    </option>
                                    <option class="p-5" value="658c4ff5518b3015acf2662d">
                                        스포츠 졸업 - 12레벨
                                    </option>
                                    <option class="p-5" value="6597818a518b3015ac571ecf">
                                        pg사 신규 5%
                                    </option>
                                    <option class="p-5" value="65b35c128b8bdb361047b53b">
                                        VIP 전용 계좌 기본
                                    </option>
                                    <option class="p-5" value="65b35c148b8bdb361047b53c">
                                        VIP 전용 계좌 보너스 0%
                                    </option>
                                    <option class="p-5" value="65b886cf8b8bdb361078de48">
                                        미성년자
                                    </option>
                                    <option class="p-5" value="661d6f725ee6c82a6ccddaf3">
                                        복귀자
                                    </option>
                                </select>
                            </td>
                            <td class="text-center bg-black-darker6">
                                보너스제한
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <x-common.toggle_switch_button id="" name="" urlAction="" />
                            </td>
                        </tr>
                        {{-- <tr>
                            <td class="text-center bg-black-darker6">단폴</td>
                            <td class="text-center bg-black-darker p-5">
                                <x-common.toggle_switch_button
                                    isCheck="{{ $member->memberConfig->mcEnableSinglePole ?? false }}"
                                    name="mcEnableSinglePole" id="mcEnableSinglePole"
                                    urlAction="{{ route('admin.member-config.update', ['field' => 'mcEnableSinglePole', 'mcNo' => $member->mID]) }}" />
                            </td>
                            <td class="text-center bg-black-darker6">
                                단폴제한금액
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcSinglePoleAmount" id="mcSinglePoleAmount"
                                    class="input-sm input-box width-full text-white formatMoney"
                                    value="{{ formatNumber(data_get($member->memberConfig, 'mcSinglePoleAmount', 0)) }}" />
                            </td>
                            <td class="text-center bg-black-darker6">두폴</td>
                            <td class="text-center bg-black-darker p-5">
                                <x-common.toggle_switch_button
                                    isCheck="{{ $member->memberConfig->mcEnableMultiPole ?? false }}"
                                    name="mcEnableMultiPole" id="mcEnableMultiPole"
                                    urlAction="{{ route('admin.member-config.update', ['field' => 'mcEnableMultiPole', 'mcNo' => $member->mID]) }}" />
                            </td>
                            <td class="text-center bg-black-darker6">
                                두폴제한금액
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcSingleMultiAmount" id="mcSingleMultiAmount"
                                    class="input-sm input-box width-full text-white formatMoney"
                                    value="{{ formatNumber(data_get($member->memberConfig, 'mcSingleMultiAmount', 0)) }}" />
                            </td>
                            <td class="text-center bg-black-darker6"></td>
                            <td class="text-center bg-black-darker p-5"></td>
                            <td class="text-center bg-black-darker6"></td>
                            <td class="text-center bg-black-darker p-5"></td>
                        </tr> --}}
                        <tr>
                            <td class="text-center bg-black-darker6">카지노 요율</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcRollingCasinoRate" id="mcRollingCasinoRate"
                                    class="input-sm input-box width-full text-white"
                                    value="{{ data_get($member->memberConfig, 'mcRollingCasinoRate') }}" />
                            </td>
                            <td class="text-center bg-black-darker6">카지노 낙첨</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcLossCasinoRate" id="mcLossCasinoRate"
                                    class="input-sm input-box width-full text-white"
                                    value="{{ data_get($member->memberConfig, 'mcLossCasinoRate') }}" />
                            </td>
                            <td class="text-center bg-black-darker6">카지노 공배팅</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcPublicBettingCasino" id="mcPublicBettingCasino"
                                    class="input-sm input-box width-full text-white"
                                    value="{{ $member->memberConfig->mcPublicBettingCasino }}" inputmode="decimal" />
                            </td>
                            <td class="text-center bg-black-darker6">슬롯 요율</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcRollingSlotRate" id="mcRollingSlotRate"
                                    class="input-sm input-box width-full text-white"
                                    value="{{ data_get($member->memberConfig, 'mcRollingSlotRate') }}" />
                            </td>
                            <td class="text-center bg-black-darker6">슬롯 낙첨</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcLossSlotRate" id="mcLossSlotRate"
                                    class="input-sm input-box width-full text-white"
                                    value="{{ data_get($member->memberConfig, 'mcLossSlotRate') }}" />
                            </td>
                            <td class="text-center bg-black-darker6">슬롯 공배팅 </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcPublicBettingSlot" id="mcPublicBettingSlot"
                                    class="input-sm input-box width-full text-white"
                                    value="{{ $member->memberConfig->mcPublicBettingSlot }}" inputmode="decimal" />
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center bg-black-darker6">
                                카지노 상한금액
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcMaxWinCasinoMoney" id="mcMaxWinCasinoMoney"
                                    class="input-sm input-box width-full text-white"
                                    value="{{ $member->memberConfig->mcMaxWinCasinoMoney ?? '' }}" placeholder="숫자입력"
                                    inputmode="decimal" />
                            </td>
                            <td class="text-center bg-black-darker6">
                                슬롯 상한금액
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mcMaxWinSlotMoney" id="mcMaxWinSlotMoney"
                                    class="form-control input-sm input-box width-full text-white" placeholder="숫자입력"
                                    value="{{ $member->memberConfig->mcMaxWinSlotMoney ?? '' }}" />
                            </td>
                            <td class="text-center bg-black-darker6">스포츠</td>
                            <td class="text-center bg-black-darker p-5"></td>
                            <td class="text-center bg-black-darker6">실시간</td>
                            <td class="text-center bg-black-darker p-5"></td>
                            <td class="text-center bg-black-darker6">파트너회원</td>
                            <td class="text-center bg-black-darker p-5">
                                <x-common.toggle_switch_button isCheck="{{ $member->mIsPartner }}" id="mIsPartner"
                                    name="mIsPartner"
                                    urlAction="{{ route('admin.status-members.update-toggle-field', ['field' => 'mIsPartner', 'mNo' => $member->mID]) }}"
                                    className="isPartnerToggle" />
                            </td>
                            <td class="text-center bg-black-darker6">파트너명 추가</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mPartnerName" id="mPartnerName-{{ $member->mNo }}"
                                    class="form-control input-sm input-box width-full text-white check-toggle-partner"
                                    value="{{ $member->mPartnerName ?? '' }}" @disabled(!$member->mIsPartner) />
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center bg-black-darker6">
                                미니게임
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <button type="button"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 width-full maintenance-item">
                                    제한 설정
                                </button>
                            </td>
                            <td class="text-center bg-black-darker6">
                                가상스포츠
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <button type="button"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 width-full maintenance-item">
                                    제한 설정
                                </button>
                            </td>
                            <td class="text-center bg-black-darker6">카지노</td>
                            <td class="text-center bg-black-darker p-5">
                                <button type="button"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 width-full member-config-modal-game"
                                    data-modal="modal_member_config_game_provider"
                                    data-action="{{ route('admin.ajax-get-member-config-game-provider', ['mID' => $member->mID, 'gpType' => 'casino']) }}">
                                    제한 설정
                                </button>
                            </td>
                            <td class="text-center bg-black-darker6">슬롯</td>
                            <td class="text-center bg-black-darker p-5">
                                <button type="button"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 width-full member-config-modal-game"
                                    data-modal="modal_member_config_game_provider"
                                    data-action="{{ route('admin.ajax-get-member-config-game-provider', ['mID' => $member->mID, 'gpType' => 'slot']) }}">
                                    제한 설정
                                </button>
                            </td>
                            <td class="text-center bg-black-darker6">
                                주의회원
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <x-common.toggle_switch_button
                                    isCheck="{{ $member->memberConfig->mcIsAttentionMember }}"
                                    id="mcIsAttentionMember" name="mcIsAttentionMember"
                                    urlAction="{{ route('admin.member-config.update', ['field' => 'mcIsAttentionMember', 'mcNo' => $member->mID]) }}" />
                            </td>
                            
                            <td class="text-center bg-black-darker6">추천인코드</td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" name="mPartnerCode" id="mPartnerCode-{{ $member->mNo }}"
                                    class="form-control input-sm input-box width-full text-white check-toggle-partner"
                                    value="{{ $member->mPartnerCode ?? '' }}" @disabled(!$member->mIsPartner) />
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center bg-black-darker6">
                                비밀번호오류
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <button type="button"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 width-full">
                                    동결해제
                                </button>
                            </td>
                            <td class="text-center bg-black-darker6">
                                이벤트제한
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <button type="button"
                                    class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 width-full member-config-event-restrictions"
                                    data-modal="modal_member_config_event_restrictions"
                                    data-action="{{ route('admin.member-config.ajax-get-mc-event-restrictions', ['mID' => $member->mID]) }}">
                                    제한 설정
                                </button>
                            </td>
                            <td class="text-center bg-black-darker6">
                                입금제한
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <x-common.toggle_switch_button
                                    isCheck="{{ $member->memberConfig->mcIsRechargeLimit ?? false }}"
                                    name="mcIsRechargeLimit" id="mcIsRechargeLimit"
                                    urlAction="{{ route('admin.member-config.update', ['field' => 'mcIsRechargeLimit', 'mcNo' => $member->mID]) }}" />
                            </td>
                            <td class="text-center bg-black-darker6">
                                출금제한
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <x-common.toggle_switch_button
                                    isCheck="{{ $member->memberConfig->mcIsWithdrawLimit ?? false }}"
                                    name="mcIsWithdrawLimit" id="mcIsWithdrawLimit"
                                    urlAction="{{ route('admin.member-config.update', ['field' => 'mcIsWithdrawLimit', 'mcNo' => $member->mID]) }}" />
                            </td>
                            <td class="text-center bg-black-darker6">
                                알박이여부
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <x-common.toggle_switch_button
                                    isCheck="{{ $member->memberConfig->mcIsAlbagi ?? false }}"
                                    name="mcIsAlbagi{{ $member->mNo }}" id="mcIsAlbagi"
                                    dataId="{{ $member->mNo }}"
                                    urlAction="{{ route('admin.member-config.update', ['field' => 'mcIsAlbagi', 'mcNo' => $member->mID]) }}"
                                    offToggle="true" />
                            </td>
                            <td class="text-center bg-black-darker6">
                                1:1계좌
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                <input type="text" placeholder="은행명" name="mConsultBankName"
                                    class="form-control input-sm input-box text-white pull-left" style="width: 33.3%"
                                    value="{{ $member->mConsultBankNameCom ? hashString($member->mConsultBankName) : $member->mConsultBankName }}" />
                                <input type="text" placeholder="계좌번호" name="mConsultBankAccount"
                                    class="form-control input-sm input-box text-white pull-left" style="width: 66.6%"
                                    value="{{ $member->mConsultBankAccountCom ? hashString($member->mConsultBankAccount) : $member->mConsultBankAccount }}" />
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center bg-black-darker6"></td>
                            <td class="text-center bg-black-darker p-5"></td>
                            <td class="text-center bg-black-darker6">
                                접속도메인
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                {{ $member->mPosition ?? '' }}</td>
                            <td class="text-center bg-black-darker6">
                                가입아이피
                            </td>
                            <td class="text-center bg-black-darker p-5 width-150">
                                <div style="height: auto; word-break: break-all">
                                    {{ $member->memberRegisterInfo()?->meIP }}
                                </div>
                            </td>
                            <td class="text-center bg-black-darker6">
                                최종접속일
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                {{ $member->mLoginDateTime ?? '' }}
                            </td>
                            <td class="text-center bg-black-darker6">
                                접속아이피
                            </td>
                            <td class="text-center bg-black-darker p-5 width-150">
                                {{ $member->memberLoginInfo()?->meIP }}
                            </td>
                            <td class="text-center bg-black-darker6">
                                접속기기
                            </td>
                            <td class="text-center bg-black-darker p-5">
                                {{ $member->memberLoginInfo()?->meDeviceID }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div class="panel panel-inverse bg-black-darker2 m-10 m-t-0 p-10">
            <div class="panel-heading p-b-13 width-full"
                style="
                            display: inline-block;
                            background: rgb(34, 34, 34);
                          ">
                <div class="panel-heading-btn">
                    <div class="btn-group">
                        <input type="text" placeholder="처리내용" id="descriptionWallet{{ $member->mNo }}"
                            name="descriptionWallet"
                            class="form-control p-5 m-0 search-input-box height-33 text-white width-300" />
                    </div>
                    <div class="btn-group">
                        <select class="form-control input-sm search-input-box height-33 text-white width-full"
                            style="border: 1px solid rgb(17, 17, 17)" id="walletType{{ $member->mNo }}"
                            name="walletType">
                            <option value="sports" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91)" disabled>
                                스포츠캐쉬
                            </option>
                            <option value="casino_slot" class="p-5"
                                style="border-bottom: 1px solid rgb(49, 65, 91)">
                                카지노캐쉬
                            </option>
                            <option value="2" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91)" disabled>
                                포커캐쉬
                            </option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <input type="text" placeholder="금액"
                            class="form-control p-5 m-0 search-input-box height-33 text-white" inputmode="decimal"
                            id="moneyNumber{{ $member->mNo }}" min="0" />
                    </div>
                    <div class="btn-group">
                        <button type="button"
                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 open-modal-ban-slot money-submit"
                            data-id="{{ $member->mNo }}">
                            캐쉬처리
                        </button>
                    </div>
                </div>
                <h4 class="panel-title m-5 pull-left">
                    <strong>:: 캐쉬처리-관리자</strong>
                </h4>
            </div>
        </div>

        <div id="MEMBER_HISTORY{{ $member->mNo }}" class="collapse width-full member-history">
            <div class="m-0 p-0 bg-black-lighter width-full el-row" colspan="16">
                <div class="el-row">
                    <div class="el-col el-col-24">
                        <div class="m-15">
                            <div class="el-row">
                                <div class="el-col el-col-24">
                                    <div class="width-full m-0 p-0 m-b-10">
                                        <div class="width-full p-10 f-s-14 f-w-700"
                                            style="background: rgb(0, 34, 68)">
                                            최근 입금 내역 10
                                            <a href="{{ route('admin.money-info.index', ['type' => 'recharge', 'search' => $member->mID]) }}"
                                                class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">상세보기</a>
                                        </div>
                                        <table
                                            class="table table-bordered table-td-valign-middle text-center text-white no-bg m-0">
                                            <thead>
                                                <tr>
                                                    <td class="text-center bg-black-darker6">
                                                        아이디 (닉네임)
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        금액
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        항목
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        신청시간
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        처리시간
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        처리상태
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recentRechargeHistory as $item)
                                                    <tr>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'mID') }} @if (data_get($item->member, 'mNick'))
                                                                ({{ data_get($item->member, 'mNick') }})
                                                            @endif
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ formatNumber(data_get($item, 'miBankMoney')) }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ MoneyInfo::MI_TYPE[data_get($item, 'miType')] }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'miRegDate') }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'mProcessDate') }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'miStatus') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if ($recentRechargeHistory->isEmpty())
                                            <div class="width-full p-15 bg-black-darker">
                                                입금 내역이 존재하지 않습니다.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="el-row">
                                <div class="el-col el-col-24">
                                    <div class="width-full m-0 p-0 m-b-10">
                                        <div class="width-full p-10 f-s-14 f-w-700"
                                            style="background: rgb(0, 34, 68)">
                                            최근 출금 내역 10
                                            <a href="{{ route('admin.money-info.index', ['type' => 'withdraw', 'search' => $member->mID]) }}"
                                                class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">상세보기</a>
                                        </div>
                                        <table
                                            class="table table-bordered table-td-valign-middle text-center text-white no-bg m-0">
                                            <thead>
                                                <tr>
                                                    <td class="text-center bg-black-darker6">
                                                        아이디 (닉네임)
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        금액
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        항목
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        신청시간
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        처리시간
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        처리상태
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recentWithdrawHistory as $item)
                                                    <tr>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'mID') }} @if (data_get($item->member, 'mNick'))
                                                                ({{ data_get($item->member, 'mNick') }})
                                                            @endif
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ formatNumber(data_get($item, 'miBankMoney')) }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ MoneyInfo::MI_TYPE[data_get($item, 'miType')] }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'miRegDate') }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'mProcessDate') }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'miStatus') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if ($recentWithdrawHistory->isEmpty())
                                            <div class="width-full p-15 bg-black-darker">
                                                출금 내역이 존재하지 않습니다.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="el-row">
                                <div class="el-col el-col-24">
                                    <div class="width-full m-0 p-0 m-b-10">
                                        <div class="width-full p-10 f-s-14 f-w-700"
                                            style="background: rgb(0, 34, 68)">
                                            배팅내역 10
                                            <a href="{{ route('admin.betting-histories.casino', ['search_input' => $member->mID]) }}"
                                                class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">상세보기</a>
                                        </div>
                                        <table
                                            class="table table-bordered table-td-valign-middle text-center text-white no-bg m-0">
                                            <thead>
                                                <tr>
                                                    <td class="text-center bg-black-darker6">
                                                        아이디 (닉네임)
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        배팅 시간
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        게임사
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        게임
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        배팅금액
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        적중금액
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        처리상태
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recentTransactionHistory as $item)
                                                    <tr>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'mID') }} @if (data_get($item->member, 'mNick'))
                                                                ({{ data_get($item->member, 'mNick') }})
                                                            @endif
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ $item->tRegDate }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ $item->game_provider->gpName ?? '' }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ $item->gName }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ formatNumber($item->tAmount) }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            <span class="text-blue-1">
                                                                <strong>{{ formatNumber($item->calcAmountCasinoAndSlotWin()) }}</strong>
                                                            </span>
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            @if ($item->calcAmountCasinoAndSlotWin() > 0)
                                                                <span class="text-primary">당첨</span>
                                                            @else
                                                                <span class="text-danger ">낙첨</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if ($recentTransactionHistory->isEmpty())
                                            <div class="width-full p-15 bg-black-darker">
                                                배팅내역 존재하지 않습니다.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="el-row">
                                <div class="el-col el-col-24">
                                    <div class="width-full m-0 p-0 m-b-10">
                                        <div class="width-full p-10 f-s-14 f-w-700"
                                            style="background: rgb(0, 34, 68)">
                                            포인트내역 10
                                            <a href="{{ route('admin.point-history.index', ['search' => $member->mID]) }}"
                                                class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">상세보기</a>
                                        </div>
                                        <table
                                            class="table table-bordered table-td-valign-middle text-center text-white no-bg m-0">
                                            <thead>
                                                <tr>
                                                    <td class="text-center bg-black-darker6">
                                                        아이디 (닉네임)
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        처리내용
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        캐쉬
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        처리시간
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        타입
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        포인트합
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recentPointHistory as $item)
                                                    <tr>
                                                        <td class="text-center bg-black-darker">
                                                            {{ data_get($item, 'mID') }} @if (data_get($item->member, 'mNick'))
                                                                ({{ data_get($item->member, 'mNick') }})
                                                            @endif
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {!! $item->message !!}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            <strong>
                                                                <font size="3"
                                                                    @if ($item->amount >= 0) color="#0066ff" @else color="#cc0066" @endif>
                                                                    <!---->
                                                                    {{ formatNumber($item->amount) }}
                                                                </font>
                                                            </strong>
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ $item->phRegDate }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            {{ $item->miWallet ?? '카지노' }}
                                                        </td>
                                                        <td class="text-center bg-black-darker">
                                                            @php
                                                                $point = $item->phPoint;
                                                                $classPointHistory = $point >= 0 ? 'text-green-2' : '';
                                                            @endphp
                                                            <span
                                                                class={{ $classPointHistory }}>{{ formatNumber($point) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if ($recentPointHistory->isEmpty())
                                            <div class="width-full p-15 bg-black-darker">
                                                포인트내역 존재하지 않습니다.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="el-row">
                                <div class="el-col el-col-24">
                                    <div class="width-full m-0 p-0 m-b-10">
                                        <div class="width-full p-10 f-s-14 f-w-700"
                                            style="background: rgb(0, 34, 68)">
                                            지인추천 리스트
                                        </div>
                                        <table
                                            class="table table-bordered table-td-valign-middle text-center text-white no-bg m-0">
                                            <thead>
                                                <tr>
                                                    <td class="text-center bg-black-darker6 p-0">
                                                        상태
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        가입일시 /허가일시
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        접속일
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        레벨
                                                    </td>
                                                    <td class="text-center bg-black-darker6 width-300">
                                                        아이디 / 카지노아이디
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        닉네임 / 이름
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        입금수
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        출금수
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        수익(입금-출금)
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        캐쉬
                                                    </td>
                                                    <td class="text-center bg-black-darker6 width-270">
                                                        간단메모
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="width-full p-15 bg-black-darker">
                                            지인추천 리스트가 존재하지 않습니다.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="el-row">
                                <div class="el-col el-col-24">
                                    <div class="width-full m-0 p-0 m-b-10">
                                        <div class="width-full p-10 f-s-14 f-w-700"
                                            style="background: rgb(0, 34, 68)">
                                            중복 아이피
                                        </div>
                                        <table
                                            class="table table-bordered table-td-valign-middle text-center text-white no-bg m-0">
                                            <thead>
                                                <tr>
                                                    <td class="text-center bg-black-darker6 p-0">
                                                        상태
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        가입일시 /허가일시
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        접속일
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        레벨
                                                    </td>
                                                    <td class="text-center bg-black-darker6 width-300">
                                                        아이디 / 카지노아이디
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        닉네임 / 이름
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        입금수
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        출금수
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        수익(입금-출금)
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        캐쉬
                                                    </td>
                                                    <td class="text-center bg-black-darker6 width-270">
                                                        간단메모
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="width-full p-15 bg-black-darker">
                                            중복 아이피 리스트가 존재하지 않습니다.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="el-row">
                                <div class="el-col el-col-24"></div>
                            </div>
                            <div class="el-row">
                                <div class="el-col el-col-24">
                                    <div class="width-full m-0 p-0 m-b-10">
                                        <div class="width-full p-10 f-s-14 f-w-700"
                                            style="background: rgb(0, 34, 68)">
                                            최근 10회 캐쉬내역
                                        </div>
                                        <table
                                            class="table table-bordered table-td-valign-middle text-center text-white no-bg m-0">
                                            <thead>
                                                <tr>
                                                    <td class="text-center bg-black-darker6">
                                                        처리내용
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        캐쉬
                                                    </td>
                                                    <td class="text-center bg-black-darker6 width-100">
                                                        처리시간
                                                    </td>
                                                    <td class="text-center bg-black-darker6 width-90">
                                                        캐쉬타입
                                                    </td>
                                                    <td class="text-center bg-black-darker6">
                                                        캐쉬합
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="width-full p-15 bg-black-darker">
                                            캐쉬내역이 존재하지 않습니다.
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div></div>
</div>

@section('custom-js')
    @vite(['resources/vite/js/page_setting/format_money.js'])
@endsection
