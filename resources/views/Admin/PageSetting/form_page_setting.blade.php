<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-content">
                @if ($errors->hasBag('page-setting'))
                    @foreach ($errors->getBag('page-setting')->all() as $error)
                        <div class="alert alert-warning" role="alert">{{ $error }}</div>
                    @endforeach
                @endif
                <div class="col-md-12 m-0 p-0">
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
                                                    <strong>사이트명(타이틀표시)</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    유저페이지 브라우저 타이틀 제목
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siName" form="siNameSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siNameSubmit">
                                            @csrf
                                            <input
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                type="input" name="siName" id="siName" placeholder="사이트명"
                                                @if ($v = old('siName', data_get($site_info, 'siName'))) value="{{ $v }}" @endif>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- Solution name -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>솔루션명</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    클라페이지에서의 솔루션명
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siSolutionName" form="siSolutionNameSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siSolutionNameSubmit">
                                            @csrf
                                            <input
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                type="input" name="siSolutionName" id="siSolutionName"
                                                placeholder="솔루션명"
                                                @if ($v = old('siSolutionName', data_get($site_info, 'siSolutionName'))) value="{{ $v }}" @endif>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- BanIP -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>자동아이피 차단여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    차단된 유저 로그인시 자동으로 아이피를 차단하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siAutoBlockIp }}" id="siAutoBlockIp"
                                            name="siAutoBlockIp"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siAutoBlockIp']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- Money transfer -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>머니이동 가능여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    롤링 미완료 시 머니이동이 가능한가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siIsTransferMoney }}" id="siIsTransferMoney"
                                            name="siIsTransferMoney"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsTransferMoney']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-3 p-3">
                            <!-- User join -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>회원가입 가능여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    회원가입을 허락하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="신규회원 가입열기" contentOff="신규회원 가입닫기"
                                            isCheck="{{ $site_info->siOpenUserJoin }}" id="siOpenUserJoin"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siOpenUserJoin']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- Whether or not members (memos/phone calls) are disclosed to partners -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>파트너에게 회원(메모/전화) 공개여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    파트너 회원관리 페이지에 간단메모/전화번호 공개여부
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siPartnerMemberInfoVisibilityLevel"
                                            form="siPartnerMemberInfoVisibilityLevelSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-6 height-full p-r-2 p-t-17 p-b-17">
                                        <form action="#" id="siPartnerMemberInfoVisibilityLevelSubmit">
                                            @csrf
                                            <select
                                                class="form-control input-sm input-box width-full text-white height-33"
                                                name="siPartnerMemberInfoVisibilityLevel">
                                                <option value="0" class="p-5" @selected(old('siPartnerMemberInfoVisibilityLevel', $site_info->siPartnerMemberInfoVisibilityLevel) == 0)>
                                                    차단회원만 공개</option>
                                                <option value="1" class="p-5" @selected(old('siPartnerMemberInfoVisibilityLevel', $site_info->siPartnerMemberInfoVisibilityLevel) == 1)>
                                                    정상회원만 공개</option>
                                                <option value="2" class="p-5" @selected(old('siPartnerMemberInfoVisibilityLevel', $site_info->siPartnerMemberInfoVisibilityLevel) == 2)>
                                                    전체공개</option>
                                                <option value="3" class="p-5" @selected(old('siPartnerMemberInfoVisibilityLevel', $site_info->siPartnerMemberInfoVisibilityLevel) == 3)>
                                                    전체비공개</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="bg-black-2 col-md-6 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="전화공개" contentOff="전화비공개"
                                            isCheck="{{ $site_info->siIsPartnerMemberInfoVisibility }}"
                                            id="siIsPartnerMemberInfoVisibility"
                                            name="siIsPartnerMemberInfoVisibility"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsPartnerMemberInfoVisibility']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- Duplicate IP notification management -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>중복아이피 알림 관리</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    중복아이피 알림을 사용하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siIsDuplicateIP }}" id="siIsDuplicateIP"
                                            name="siIsDuplicateIP"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsDuplicateIP']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- Captcha -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>리캡챠 사용여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    로그인시 리캡챠를 이용하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button isCheck="{{ $site_info->siEnableCaptcha }}"
                                            content="사용" contentOff="미사용" id="siEnableCaptcha"
                                            name="siEnableCaptcha"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siEnableCaptcha']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-3 p-3">
                            <!-- Keyword -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>파트너 노출 관리</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    파트너 타이틀, 노출모드 설정
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siPartners" form="siPartnersSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siPartnersSubmit">
                                            @csrf
                                            <div class="bg-black-2 col-md-3 height-full p-0 m-0 p-t-17 p-b-17">
                                                <input
                                                    value="{{ $site_info->siPartners['deputy_headquarters'] ?? '' }}"
                                                    class="form-control width-full search-input-box input-sm height-33 text-light p-5"
                                                    type="input" placeholder="부본사"
                                                    name="siPartners[deputy_headquarters]">
                                            </div>
                                            <div class="bg-black-2 col-md-3 height-full p-0 m-0 p-t-17 p-b-17">
                                                <input value="{{ $site_info->siPartners['distributor'] ?? '' }}"
                                                    class="form-control width-full search-input-box input-sm height-33 text-light p-5"
                                                    type="input" placeholder="총판" name="siPartners[distributor]">
                                            </div>
                                            <div class="bg-black-2 col-md-3 height-full p-0 m-0 p-t-17 p-b-17">
                                                <input value="{{ $site_info->siPartners['agency'] ?? '' }}"
                                                    class="form-control width-full search-input-box input-sm height-33 text-light p-5"
                                                    type="input" placeholder="대리점" name="siPartners[agency]">
                                            </div>
                                            <div class="bg-black-2 col-md-3 height-full p-0 m-0 p-t-17 p-b-17">
                                                <select
                                                    class="form-control input-sm input-box width-full text-white height-33"
                                                    name="siPartnersMode">
                                                    <option value="0" class="p-5"
                                                        @selected($site_info->siPartnersMode == 0)>
                                                        모드1</option>
                                                    <option value="1" class="p-5"
                                                        @selected($site_info->siPartnersMode == 1)>
                                                        모드2</option>
                                                </select>
                                            </div>
                                        </form>
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
                                                    <strong>저배당률 제한 기준</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    해당 기준 배당률 이하로 단폴, 다폴 제한됩니다.
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siLowOddsLimit" form="siLowOddsLimitSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siLowOddsLimitSubmit">
                                            @csrf
                                            <input
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                type="input" name="siLowOddsLimit" id="siLowOddsLimit"
                                                placeholder="저배당률 제한 기준"
                                                @if ($v = old('siLowOddsLimit', data_get($site_info, 'siLowOddsLimit'))) value="{{ $v }}" @endif>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>클라에서 배팅내역 유지시간</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    클라페이지에서 유지시간이 지난 내역은 나타나지 않음
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siMaxHoursHistories" form="siMaxHoursHistoriesSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siMaxHoursHistoriesSubmit">
                                            @csrf
                                            <input
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                type="number" name="siMaxHoursHistories" id="siMaxHoursHistories"
                                                placeholder="시간"
                                                @if ($v = old('siMaxHoursHistories', data_get($site_info, 'siMaxHoursHistories'))) value="{{ $v }}" @endif>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>쪽지 관리</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    쪽지를 읽어야만 페이지이동이 가능한가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                            isCheck="{{ $site_info->siRequireReadNote }}" id="siRequireReadNote"
                                            name="siRequireReadNote"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siRequireReadNote']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>계좌문의 자동답변 사용여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    계좌문의시 자동답변을 사용하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                            isCheck="{{ $site_info->siAutoReplyConsultation }}"
                                            id="siAutoReplyConsultation" name="siAutoReplyConsultation"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siAutoReplyConsultation']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>빠른 계좌문의 사용여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    빠른 계좌문의를 사용하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                            isCheck="{{ $site_info->siEnableConsultation }}"
                                            id="siEnableConsultation"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siEnableConsultation']) }}"
                                            size="big" />
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
                                                    <strong>재문의 시간차</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    회원의 잦은 문의 요청방지를 위한 시간차 설정
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siReinquiryTimeInterval" form="siReinquiryTimeIntervalSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siReinquiryTimeIntervalSubmit">
                                            @csrf
                                            <input
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                type="input" name="siReinquiryTimeInterval"
                                                id="siReinquiryTimeInterval" placeholder="저배당률 제한 기준"
                                                @if ($v = old('siReinquiryTimeInterval', data_get($site_info, 'siReinquiryTimeInterval'))) value="{{ $v }}" @endif>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>알박이 알림을 사용하는가?</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    관리자에서 알박이 알림을 이용하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siIsAlbagiNotify }}" id="siIsAlbagiNotify"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsAlbagiNotify']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>탈퇴회원 재가입 여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    탈퇴회원의 전화번호 및 계좌번호로 재가입이 가능한가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siIsOpenUserRejoin }}" id="siIsOpenUserRejoin"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsOpenUserRejoin']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>주의회원 배팅알림</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    주의회원이 스포츠 및 실시간 배팅 시 알림을 사용하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siWarningMaxBet }}" id="siWarningMaxBet"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siWarningMaxBet']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>유저페이지에서 알람을 사용하는가?</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    쪽지, 문의답변 알림음을 이용하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siIsClientAlertSound }}"
                                            id="siIsClientAlertSound"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsClientAlertSound']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>스포츠 롤백 알림 주기 설정</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    설정한 시간동안 여러번 발생하여도 1회만 알림
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siSportsRollbackNotifyInterval"
                                            form="siSportsRollbackNotifyIntervalSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siSportsRollbackNotifyIntervalSubmit">
                                            @csrf
                                            <select
                                                class="form-control input-sm input-box width-full text-white height-33"
                                                name="siSportsRollbackNotifyInterval">
                                                @for ($i = 0; $i <= 10; $i++)
                                                    <option value="{{ $i }}" class="p-5"
                                                        @selected(old('siSportsRollbackNotifyInterval', $site_info->siSportsRollbackNotifyInterval) == $i)>
                                                        {{ $i == 0 ? '미사용' : $i . '분' }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                    <strong>자유게시판 타이틀</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    자유게시판 타이틀
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siFeedTitle" form="siFeedTitleSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siFeedTitleSubmit">
                                            @csrf
                                            <input
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                type="input" name="siFeedTitle" id="siFeedTitle" placeholder="타이틀"
                                                @if ($v = old('siFeedTitle', data_get($site_info, 'siFeedTitle'))) value="{{ $v }}" @endif>
                                        </form>
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
                                                    <strong>자유게시판 댓글 입력수</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    댓글 글짜수
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siFeedCommentCharLimit" form="siFeedCommentCharLimitSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siFeedCommentCharLimitSubmit">
                                            @csrf
                                            <input
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                type="number" name="siFeedCommentCharLimit"
                                                id="siFeedCommentCharLimit" placeholder="개"
                                                @if ($v = old('siFeedCommentCharLimit', data_get($site_info, 'siFeedCommentCharLimit'))) value="{{ $v }}" @endif>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>게시판 사용 여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    게시판을 사용하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siIsUseNotificationBoard }}"
                                            id="siIsUseNotificationBoard"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsUseNotificationBoard']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>신규유저 자동계좌 무시 여부</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    신규유저 첫 입금 시 자동계좌가 나가는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siIsAutoWithdrawalNewUser }}"
                                            id="siIsAutoWithdrawalNewUser"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsAutoWithdrawalNewUser']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- History -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>포커 입금 시 잔액을 합산하여 롤링을 계산하는가?</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    포커 입금 시 잔액을 합산하여 롤링을 계산하는가?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="예" contentOff="아니오"
                                            isCheck="{{ $site_info->siIsPokerRechargeRolling }}"
                                            id="siIsPokerRechargeRolling"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsPokerRechargeRolling']) }}"
                                            size="big" />
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
                                                    <strong>클라에서 쪽지 유지시간</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    클라페이지에서 유지시간이 지난 내역은 나타나지 않음
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siClientMessageRetentionTime"
                                            form="siClientMessageRetentionTimeSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siClientMessageRetentionTimeSubmit">
                                            @csrf
                                            <input
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                type="input" name="siClientMessageRetentionTime"
                                                id="siClientMessageRetentionTime" placeholder="시간"
                                                @if ($v = old('siClientMessageRetentionTime', data_get($site_info, 'siClientMessageRetentionTime'))) value="{{ $v }}" @endif>
                                        </form>
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
                                                    <strong>공배팅요율</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    기본 공배팅요율을 적용합니다
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siSportsBettingRate" form="siSportsBettingRateSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siSportsBettingRateSubmit">
                                            @csrf
                                            <input
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                type="input" name="siSportsBettingRate" id="siSportsBettingRate"
                                                placeholder="시간"
                                                @if ($v = old('siSportsBettingRate', data_get($site_info, 'siSportsBettingRate'))) value="{{ $v }}" @endif>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">

                        {{-- <div class="col-md-3 p-3"> <!-- Required recevice response 1:1-->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>1:1문의 답변 받아야 문의 가능</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="1:1문의 답변 받아야 문의 가능"
                                            isCheck="{{ $site_info->siRequiredReply }}" id="siRequiredReply"
                                            name="siRequiredReply"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siRequiredReply']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3"> <!-- Open type -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>회원사이트 운영중지(점검)</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <x-common.toggle_switch_button content="회원사이트 운영중지(점검)"
                                            isCheck="{{ $site_info->siOpenType }}" id="siOpenType"
                                            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siOpenType']) }}"
                                            size="big" />
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    {{-- <div class="col-md-12 p-0">
                        <div class="col-md-3 p-3"> <!-- Open type -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="bg-black-2 col-md-12 text-right">
                                    <div class="pull-left m-t-10 text-left">
                                        <label class="f-s-15 m-l-4"><strong>자동 로그아웃시간</strong></label>
                                        <label></label>
                                    </div>
                                    <button type="button"
                                        class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                        data-action="{{ route('admin.page-setting.index-save-config') }}"
                                        data-item="siTimeOUt" form="siTimeOUtSubmit">
                                        <strong>내용저장</strong>
                                    </button>
                                </div>
                                <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                    <form action="#" id="siTimeOUtSubmit">
                                        @csrf
                                        <select class="form-control input-sm input-box width-full text-white height-33"
                                            name="siTimeOUt" id="siTimeOUt">
                                            @foreach (config('constant_view.VIEW.selectSiTimeOUt') as $time)
                                                <option value="{{ $time }}" class="p-5" 
                                                    @selected(old('siTimeOUt', $site_info->siTimeOUt) == $time)>
                                                        {{ $time }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3"> <!-- Email -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="bg-black-2 col-md-12 text-right">
                                    <div class="pull-left m-t-10 text-left">
                                        <label class="f-s-15 m-l-4"><strong>사이트 email</strong></label>
                                        <label></label>
                                    </div>
                                    <button type="button"
                                        class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                        data-action="{{ route('admin.page-setting.index-save-config') }}"
                                        data-item="siEmail" form="siEmailSubmit">
                                        <strong>내용저장</strong>
                                    </button>
                                </div>
                                <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                    <form action="#" id="siEmailSubmit">
                                        @csrf
                                        <input
                                            class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                            type="input" name="siEmail" id="inputSiEmail"
                                            @if ($v = old('siEmail', data_get($site_info, 'siEmail'))) value="{{ $v }}" @endif>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3"> <!-- Tel -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="bg-black-2 col-md-12 text-right">
                                    <div class="pull-left m-t-10 text-left">
                                        <label class="f-s-15 m-l-4"><strong>사이트 전화번호</strong></label>
                                        <label></label>
                                    </div>
                                    <button type="button"
                                        class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                        data-action="{{ route('admin.page-setting.index-save-config') }}"
                                        data-item="siTel" form="siTelSubmit">
                                        <strong>내용저장</strong>
                                    </button>
                                </div>
                                <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                    <form action="#" id="siTelSubmit">
                                        @csrf
                                        <input
                                            class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                            type="input" name="siTel" id="inputSiTel"
                                            @if ($v = old('siTel', data_get($site_info, 'siTel'))) value="{{ $v }}" @endif>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3"> <!-- Bank account owner -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="bg-black-2 col-md-12 text-right">
                                    <div class="pull-left m-t-10 text-left">
                                        <label class="f-s-15 m-l-4"><strong>사이트 은행명/계좌번호/이름</strong></label>
                                        <label></label>
                                    </div>
                                    <button type="button"
                                        class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                        data-action="{{ route('admin.page-setting.index-save-config') }}"
                                        data-item="siBankBankAccountOwner" form="siBankBankAccountOwnerSubmit">
                                        <strong>내용저장</strong>
                                    </button>
                                </div>
                                <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                    <form action="#" id="siBankBankAccountOwnerSubmit">
                                        @csrf
                                        <input
                                            class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                            type="input" name="siBankBankAccountOwner" id="siBankBankAccountOwner"
                                            @if ($v = old('siBankBankAccountOwner', data_get($site_info, 'info_bank'))) value="{{ $v }}" @endif>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-3 p-3"> <!-- Description -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="bg-black-2 col-md-12 text-right">
                                    <div class="pull-left m-t-10 text-left">
                                        <label class="f-s-15 m-l-4"><strong>사이트 description</strong></label>
                                        <label></label>
                                    </div>
                                    <button type="button"
                                        class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                        data-action="{{ route('admin.page-setting.index-save-config') }}"
                                        data-item="siDescription" form="siDescriptionSubmit">
                                        <strong>내용저장</strong>
                                    </button>
                                </div>
                                <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                    <form action="#" id="siDescriptionSubmit">
                                        @csrf
                                        <input
                                            class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                            type="input" name="siDescription" id="siDescription"
                                            @if ($v = old('siDescription', data_get($site_info, 'siDescription'))) value="{{ $v }}" @endif>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3"> <!-- Keyword -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="bg-black-2 col-md-12 text-right">
                                    <div class="pull-left m-t-10 text-left">
                                        <label class="f-s-15 m-l-4"><strong>사이트 keyword</strong></label>
                                        <label></label>
                                    </div>
                                    <button type="button"
                                        class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                        data-action="{{ route('admin.page-setting.index-save-config') }}"
                                        data-item="siKeywords" form="siKeywordsSubmit">
                                        <strong>내용저장</strong>
                                    </button>
                                </div>
                                <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                    <form action="#" id="siKeywordsSubmit">
                                        @csrf
                                        <input
                                            class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                            type="input" name="siKeywords" id="siKeywords"
                                            @if ($v = old('siKeywords', data_get($site_info, 'siKeywords'))) value="{{ $v }}" @endif>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-12 p-0">
                        <div class="col-md-12 p-3">
                            <!-- Name -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>고액 배팅 알람</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    지정한 금액 이상 배팅시 알람 작동
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siWarningMaxBetValues" form="siWarningMaxBetValuesSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full">
                                        <form action="#" id="siWarningMaxBetValuesSubmit">
                                            @csrf
                                            <div class="bg-black-2 col-md-2 height-full p-l-1 p-r-1 p-t-17 p-b-17">
                                                <select
                                                    class="form-control input-sm input-box width-full text-white height-33"
                                                    name="siWarningMaxBetValues[sports]">
                                                    @foreach (config('constant_view.MAX_BETTING_VALUES') as $value)
                                                        <option value="{{ $value }}" class="p-5"
                                                            @selected($site_info->siWarningMaxBetValues['sports'] == $value)>
                                                            스포츠:
                                                            {{ $value == 0 ? '사용않함' : formatNumber($value) . '원' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="bg-black-2 col-md-2 height-full p-l-1 p-r-1 p-t-17 p-b-17">
                                                <select
                                                    class="form-control input-sm input-box width-full text-white height-33"
                                                    name="siWarningMaxBetValues[realtime]">
                                                    @foreach (config('constant_view.MAX_BETTING_VALUES') as $value)
                                                        <option value="{{ $value }}" class="p-5"
                                                            @selected($site_info->siWarningMaxBetValues['realtime'] == $value)>
                                                            실시간:
                                                            {{ $value == 0 ? '사용않함' : formatNumber($value) . '원' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="bg-black-2 col-md-2 height-full p-l-1 p-r-1 p-t-17 p-b-17">
                                                <select
                                                    class="form-control input-sm input-box width-full text-white height-33"
                                                    name="siWarningMaxBetValues[minigame]">
                                                    @foreach (config('constant_view.MAX_BETTING_VALUES') as $value)
                                                        <option value="{{ $value }}" class="p-5"
                                                            @selected($site_info->siWarningMaxBetValues['minigame'] == $value)>
                                                            미니게임:
                                                            {{ $value == 0 ? '사용않함' : formatNumber($value) . '원' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="bg-black-2 col-md-2 height-full p-l-1 p-r-1 p-t-17 p-b-17">
                                                <select
                                                    class="form-control input-sm input-box width-full text-white height-33"
                                                    name="siWarningMaxBetValues[casino]">
                                                    @foreach (config('constant_view.MAX_BETTING_VALUES') as $value)
                                                        <option value="{{ $value }}" class="p-5"
                                                            @selected($site_info->siWarningMaxBetValues['casino'] == $value)>
                                                            카지노:
                                                            {{ $value == 0 ? '사용않함' : formatNumber($value) . '원' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="bg-black-2 col-md-2 height-full p-l-1 p-r-1 p-t-17 p-b-17">
                                                <select
                                                    class="form-control input-sm input-box width-full text-white height-33"
                                                    name="siWarningMaxBetValues[virtual_sports]">
                                                    @foreach (config('constant_view.MAX_BETTING_VALUES') as $value)
                                                        <option value="{{ $value }}" class="p-5"
                                                            @selected($site_info->siWarningMaxBetValues['virtual_sports'] == $value)>
                                                            가상게임:
                                                            {{ $value == 0 ? '사용않함' : formatNumber($value) . '원' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="bg-black-2 col-md-2 height-full p-l-1 p-r-1 p-t-17 p-b-17">
                                                <select
                                                    class="form-control input-sm input-box width-full text-white height-33"
                                                    name="siWarningMaxBetValues[parsing_casino]">
                                                    @foreach (config('constant_view.MAX_BETTING_VALUES') as $value)
                                                        <option value="{{ $value }}" class="p-5"
                                                            @selected($site_info->siWarningMaxBetValues['parsing_casino'] == $value)>
                                                            파싱카지노:
                                                            {{ $value == 0 ? '사용않함' : formatNumber($value) . '원' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                    <strong>차단, 탈퇴회원 로그인시 메시지</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    차단, 탈퇴회원 로그인시 메시지
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siBlockedMemberLoginMessage"
                                            form="siBlockedMemberLoginMessageSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siBlockedMemberLoginMessageSubmit">
                                            @csrf
                                            <textarea id="siBlockedMemberLoginMessage" name="siBlockedMemberLoginMessage" rows="19" class="form-control">{{ $site_info->siBlockedMemberLoginMessage }}</textarea>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- Member first time login content -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>가입 환영 모달</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    회원가입시 가입 환영 모달 작성
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siMemberFirstTimeLoginContents"
                                            form="siMemberFirstTimeLoginContentsSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siMemberFirstTimeLoginContentsSubmit">
                                            @csrf
                                            <textarea id="siMemberFirstTimeLoginContents" name="siMemberFirstTimeLoginContents" rows="5"
                                                class="form-control js__editor">{!! $site_info->siMemberFirstTimeLoginContents !!}</textarea>
                                        </form>
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
                                                    <strong>가입 환영 SMS</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    회원가입시 가입 환영 SMS 작성
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siSMSContents" form="siSMSContentsSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siSMSContentsSubmit">
                                            @csrf
                                            <textarea id="siSMSContents" name="siSMSContents" rows="19" class="form-control">{!! $site_info->siSMSContents !!}</textarea>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- Member note content -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>가입 환영 쪽지</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    회원가입시 가입 환영 메시지 작성
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siMemberNoteContents" form="siMemberNoteContentsSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siMemberNoteContentsSubmit">
                                            @csrf
                                            <textarea id="siMemberNoteContents" name="siMemberNoteContents" rows="5" class="form-control js__editor">{!! $site_info->siMemberNoteContents !!}</textarea>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                    <strong>관리자 접근 아이피</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    특정 아이피에서만 관리자 접근 가능
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siAdminAccessIP" form="siAdminAccessIPSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siAdminAccessIPSubmit">
                                            @csrf
                                            <textarea id="siAdminAccessIP" name="siAdminAccessIP" rows="10" class="form-control">{{ $site_info->siAdminAccessIP }}</textarea>
                                        </form>
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
                                                    <strong>수동 차단 아이피</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    특정 아이피 유저 접근 차단
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siManualBlockIP" form="siManualBlockIPSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siManualBlockIPSubmit">
                                            @csrf
                                            <textarea id="siManualBlockIP" name="siManualBlockIP" rows="10" class="form-control">{{ $site_info->siManualBlockIP }}</textarea>
                                        </form>
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
                                                    <strong>자동 차단 아이피</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    특정 아이피 유저 접근 차단
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siAutomationBlockIP" form="siAutomationBlockIPSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siAutomationBlockIPSubmit">
                                            @csrf
                                            <textarea id="siAutomationBlockIP" name="siAutomationBlockIP" rows="10" class="form-control">{{ $site_info->siAutomationBlockIP }}</textarea>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 p-3">
                            <!-- Black list -->
                            <div
                                class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
                                <div class="col-md-12 p-0 text-center">
                                    <div class="bg-black-2 col-md-12 text-right">
                                        <div class="pull-left m-t-10 text-left">
                                            <div>
                                                <span class="f-s-15 m-l-4">
                                                    <strong>블랙 모바일 번호 설정</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    특정 번호로 가입을 차단
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siBlackList" form="siBlackListSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <form action="#" id="siBlackListSubmit">
                                            @csrf
                                            <textarea id="siBlackList" name="siBlackList" cols="30" rows="10" class="form-control"
                                                placeholder="발송할 회원아이디를 적을수 있게한다 Example: memberid">{{ isset($site_info->siBlackList) ? implode(PHP_EOL, $site_info->siBlackList) : '' }}</textarea>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                    <strong>알리고 설정</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    알리고 설정
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                                            data-action="{{ route('admin.page-setting.index-save-config') }}"
                                            data-item="siSMS" form="siSMSSubmit">
                                            <strong>내용저장</strong>
                                        </button>
                                    </div>
                                    <form action="#" id="siSMSSubmit">
                                        @csrf
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <div class="m-b-10 text-left el-row">핸드폰번호:</div>
                                            <input type="text" placeholder="핸드폰번호"
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                name="siSMSPhone" id="siSMSPhone"
                                                @if ($v = old('siSMSPhone', data_get($site_info, 'siSMSPhone'))) value="{{ $v }}" @endif>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <div class="m-b-10 text-left el-row">API 키:</div>
                                            <input type="text" placeholder="API키"
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                name="siSMSApiKey" id="siSMSApiKey"
                                                @if ($v = old('siSMSApiKey', data_get($site_info, 'siSMSApiKey'))) value="{{ $v }}" @endif>
                                        </div>
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <div class="m-b-10 text-left el-row">아이디:</div>
                                            <input type="text" placeholder="아이디"
                                                class="form-control width-full search-input-box input-sm height-33 text-white2 p-5"
                                                name="siSMSId" id="siSMSId"
                                                @if ($v = old('siSMSId', data_get($site_info, 'siSMSId'))) value="{{ $v }}" @endif>
                                        </div>
                                    </form>
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
                                                    <strong>OTP 설정</strong>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="f-s-12 m-l-4 text-gray">
                                                    관리자 로그인 시 OTP 사용 유무
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                        <div class="m-b-10 text-left d-flex gap-10">
                                            <form action="#" id="siOTPAdminIDSubmit">
                                                @csrf
                                                <input type="text" placeholder="관리자 아이디"
                                                    class="form-control search-input-box input-sm height-33 text-white2 p-5 pull-left"
                                                    name="siOTPAdminID" id="siOTPAdminID"
                                                    @if ($v = old('siOTPAdminID', data_get($site_info, 'siOTPAdminID'))) value="{{ $v }}" @endif
                                                    style="width: 100px">
                                            </form>
                                            <button type="button"
                                                class="btnstyle1 btnstyle1-success btnstyle1-sm height-33 pull-left m-l-5 btn-submit"
                                                data-action="{{ route('admin.page-setting.index-save-config') }}"
                                                data-item="siOTPAdminID" form="siOTPAdminIDSubmit">
                                                <strong>생성</strong>
                                            </button>
                                            <x-common.toggle_switch_button content="예" contentOff="아니오"
                                                isCheck="{{ $site_info->siIsUseOTP }}" id="siIsUseOTP"
                                                name="siIsUseOTP"
                                                urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siIsUseOTP']) }}"
                                                width="100px" size="big" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('custom-css')
    @vite(['resources/vite/css/toggle-switch/toggle_style.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/toggle_switch/toggle_switch.js', 'resources/vite/js/page_setting/index.js'])
@endsection
