<div class="animated fadeInUp panel panel-inverse bg-black-darker2 m-t-10 p-0">
    <div class="panel-heading-page p-b-13" style="background: rgb(0, 34, 68)">
        <div class="panel-heading-btn-page">
            <form action="{{ route('admin.status-members.index') }}" method="get">
                <div class="btn-group">
                    <div class="input-daterange">
                        <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange">
                            <i class="fa fa-calendar"></i>
                            <input autocomplete="off" placeholder="검색시작날짜" name="start_date" class="el-range-input"
                                value="{{ request('start_date', '') }}" id="js__single-start-date" />
                            <span class="el-range-separator">To</span>
                            <input autocomplete="off" placeholder="검색마지막날짜" name="end_date" class="el-range-input"
                                value="{{ request('end_date', '') }}" id="js__single-end-date" />
                        </div>
                    </div>
                </div>
                <div class="btn-group">
                    <select class="form-control input-sm search-input-box height-33 text-white width-full"
                        style="border: 1px solid rgb(17, 17, 17)" name="select_field_search" id="select_field_search">
                        @foreach (config('constant_view.VIEW.selectFieldMember') as $key => $value)
                            <option value="{{ $key }}" class="p-5"
                                style="border-bottom: 1px solid rgb(49, 65, 91)"
                                @if ($key == request('select_field_search', '99')) selected @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="btn-group">
                    <input placeholder="검색어입력" type="text" autocomplete="off" id="search" name="search"
                        class="form-control input-sm width-200 search-input-box height-33 p-l-5 text-white"
                        style="float: left" value="{{ request('search', '') }}" />
                    <button class="btnstyle1 btnstyle1-inverse3 btnstyle1-sm height-33 m-r-15 m-l-5" style="float: left"
                        type="submit" name="btn_submit" value="click">
                        검색
                    </button>
                </div>
                <div class="btn-group m-l-1 m-r-2">
                    {{-- <button type="button" class="btnstyle1 btnstyle1-info btnstyle1-sm height-31 m-r-10">
                        실입금자(0)
                    </button> --}}
                    <a href="{{ route(Route::currentRouteName(), [
                        'member_logged_by_days' => true,
                        'select_days_member_logged' => request('select_days_member_logged', Cookie::get('select_days_member_logged', 5)),
                    ]) }}"
                        class="btnstyle1 btnstyle1-warning btnstyle1-sm height-31 m-r-10">
                        5회/7일 미접속 회원({{ data_get($total, 'total_member_logged_by_day', 0) }})
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['member_status_all' => true]) }}"
                        class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">
                        전체({{ data_get($total, 'total_member_status_all', 0) }})
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['member_status_normal' => true]) }}"
                        class="btnstyle1 btnstyle1-primary btnstyle1-sm height-31">
                        정상({{ data_get($total, 'total_member_status_normal', 0) }})
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['member_status_pending' => true]) }}"
                        class="btnstyle1 btnstyle1-info btnstyle1-sm height-31">
                        대기({{ data_get($total, 'total_member_status_pending', 0) }})
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['member_status_stop' => true]) }}"
                        class="btnstyle1 btnstyle1-danger btnstyle1-sm height-31">
                        차단({{ data_get($total, 'total_member_status_stop', 0) }})
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['member_status_black_list' => true]) }}"
                        class="btnstyle1 btnstyle1-warning btnstyle1-sm height-31 m-r-10">
                        탈퇴({{ data_get($total, 'total_member_status_black_list', 0) }})
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['member_top_200_profit' => true]) }}"
                        class="btnstyle1 btnstyle1-primary btnstyle1-sm height-31">
                        <i class="ion-plus"></i> 탑200
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['member_bottom_200_profit' => true]) }}"
                        class="btnstyle1 btnstyle1-danger btnstyle1-sm height-31 m-r-10">
                        <i class="ion-minus"></i> 탑200
                    </a>

                    <a href="{{ route(Route::currentRouteName(), ['member_online' => true]) }}"
                        class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">
                        현재접속자
                    </a>
                    <button type="button" class="btnstyle1 btnstyle1-warning btnstyle1-sm height-31">
                        장기간 미접속자
                    </button>
                    <span>
                        <div role="tooltip" id="el-popover-1873" aria-hidden="true" class="el-popover el-popper"
                            tabindex="0" style="width: 200px; display: none">
                            <div>
                                <span class="f-s-12">:: 장기간 미접속자 설정</span>
                            </div>
                            <div class="pull-right m-t-3">
                                <button type="button"
                                    class="btn btnstyle1 btnstyle1-inverse2 btnstyle1-sm height-20 width-20 text-white p-0"
                                    style="position: absolute; top: 5px; right: 5px">
                                    <i class="ion-close"></i>
                                </button>
                            </div>
                            <div class="btn-group m-t-7">
                                <select class="btn form-control input-sm input-box width-150 text-white"
                                    style="border: 1px solid rgb(49, 65, 91)">
                                    <option value="1" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91)">
                                        1주 이상
                                    </option>
                                    <option value="2" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91)">
                                        2주 이상
                                    </option>
                                    <option value="3" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91)">
                                        3주 이상
                                    </option>
                                    <option value="4" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91)">
                                        4주 이상
                                    </option>
                                    <option value="5" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91)">
                                        5주 이상
                                    </option>
                                    <option value="6" class="p-5"
                                        style="border-bottom: 1px solid rgb(49, 65, 91)">
                                        6주 이상
                                    </option>
                                </select>
                            </div>
                        </div>
                        <span class="el-popover__reference-wrapper">
                            <button type="button"
                                class="el-button btnstyle1 btnstyle1-warning btnstyle1-xs height-31 width-30 p-0 m-0 text-white m-r-10 el-button--default el-popover__reference"
                                aria-describedby="el-popover-1873" tabindex="0">
                                <span><i class="fa ion-gear-a text-white2 f-s-20 m-3 m-l-1"></i></span>
                            </button>
                        </span>
                    </span>
                    <a href="{{ route(Route::currentRouteName(), ['member_cash_casino' => true]) }}" type="button"
                        class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">
                        카지노캐쉬 보유
                    </a>


                    <button type="button" class="btnstyle1 btnstyle1-danger btnstyle1-sm height-31">
                        단폴<i class="ion-close"></i>
                    </button>
                    <button type="button" class="btnstyle1 btnstyle1-danger btnstyle1-sm height-31">
                        두폴<i class="ion-close"></i>
                    </button>
                    <button type="button" class="btnstyle1 btnstyle1-danger btnstyle1-sm height-31">
                        미니게임<i class="ion-close"></i>
                    </button>
                    <button type="button" class="btnstyle1 btnstyle1-danger btnstyle1-sm height-31">
                        가상스포츠<i class="ion-close"></i>
                    </button>
                    <button type="button" class="btnstyle1 btnstyle1-danger btnstyle1-sm height-31">
                        카지노<i class="ion-close"></i>
                    </button>
                    <button type="button" class="btnstyle1 btnstyle1-danger btnstyle1-sm height-31 m-r-10">
                        (단,두폴)금액제한자
                    </button>
                    <a href="{{ route(Route::currentRouteName(), ['mc_suspicion' => '1']) }}"
                        class="btnstyle1 btnstyle1-danger height-31 m-r-10">양방의심유저</a>
                    <a href="{{ route(Route::currentRouteName(), ['mc_bool' => 'mcIsAttentionMember']) }}"
                        class="btnstyle1 btnstyle1-danger height-31 m-r-10">주의회원</a>
                    <button type="button" data-toggle="collapse" data-target="#MEMBER_CSEP_MAKE"
                        class="btnstyle1 btnstyle1-primary btnstyle1-xs height-31 text-white">
                        <i class="fa ion-android-person-add text-white2 f-s-20 m-t-3 m-r-3"></i>
                    </button>
                    <button type="button" class="btnstyle1 btnstyle1-inverse3 btnstyle1-sm height-31 m-l-10 m-r-10">
                        카지노아이디생성
                    </button>
                    <button type="button" class="btnstyle1 btnstyle1-inverse3 btnstyle1-sm height-31 m-l-10 m-r-10">
                        미니아이디생성
                    </button>
                    <button type="button" class="btnstyle1 btnstyle1-inverse3 btnstyle1-sm height-31 m-l-10 m-r-10">
                        토큰아이디생성
                    </button>
                    <a href="{{ route('admin.status-members.action-button', ['name' => 'hash-phone']) }}"
                        class="btnstyle1 btnstyle1-inverse3 height-31 m-l-10 m-r-10 confirm-action">번호삭제</a>
                    <a href="{{ route('admin.status-members.action-button', ['name' => 'hash-consultations']) }}"
                        class="btnstyle1 btnstyle1-inverse3 height-31 m-l-10 m-r-10 confirm-action">1:1계좌 삭제</a>
                </div>
            </form>
            <div class="btn-group">
                <x-common.toggle_switch_button content="테스트유저 노출" contentOff="테스트유저 비노출" isCheck="true" urlAction=""
                    width="150px" size="big" />
            </div>
        </div>
        <h4 class="panel-title m-5">
            <strong><i class="fa fa-arrow-down"></i>회원관리 </strong>
        </h4>
    </div>
    <div id="MEMBER_CSEP_MAKE" aria-expanded="true" class="width-full collapse">
        <div class="panel panel-inverse bg-black m-t-20 m-b-50 p-10">
            <form id="create-member-form" method="POST" action="{{ route('admin.status-members.create-member') }}">
                @csrf
                <div class="panel-heading p-b-13" style="background: rgb(34, 34, 34)">
                    <div class="panel-heading-btn">
                        <div class="btn-group">
                            <input type="text" placeholder="추천인코드" id="mPartnerCode" name="mPartnerCode"
                                class="form-control p-5 m-0 search-input-box height-33 text-white" />
                        </div>
                        <div class="btn-group">
                            <button type="button" id="btn-check-member-id" target-url="{{ route('admin.status-members.check-member-id') }}"
                                class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div class="btn-group">
                            <input type="text" placeholder="아이디" id="mID" name="mID"
                                class="form-control p-5 m-0 search-input-box height-33 text-white" />
                        </div>
                        <div class="btn-group">
                            <input type="text" placeholder="패스워드" id="mPW" name="mPW"
                                class="form-control p-5 m-0 search-input-box height-33 text-white" />
                        </div>
                        <div class="btn-group">
                            <input type="text" placeholder="닉네임" id="mNick" name="mNick"
                                class="form-control p-5 m-0 search-input-box height-33 text-white" />
                        </div>
                        <div class="btn-group">
                            <button type="button" id="btn-create-member" class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">
                                회원생성
                            </button>
                        </div>
                    </div>
                    <h4 class="panel-title m-5">
                        <strong>:: 회원추가-관리자</strong>
                    </h4>
                </div>
            </form>
        </div>
    </div>
    <div class="no-bg m-t-10">
        @if (session('success'))
            <div class="alert alert-success">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif
        <table id="RegMemberTable" class="table table-bordered table-td-valign-middle text-center text-white no-bg">
            <thead>
                <tr>
                    <td class="text-center bg-black-darker6 p-0">상태</td>
                    <td class="text-center bg-black-darker6">파트너명</td>
                    <td class="text-center bg-black-darker6">
                        가입일시 /허가일시
                        @include('Admin.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_register_date',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">
                        접속일
                        @include('Admin.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_login_date_time',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">레벨</td>
                    <td class="text-center bg-black-darker6 width-300">
                        아이디
                    </td>
                    <td class="text-center bg-black-darker6">닉네임 / 이름</td>
                    <td class="text-center bg-black-darker6">추천인</td>
                    <td class="text-center bg-black-darker6">
                        입금수
                        @include('Admin.Common.pair_button_arrow_sort_new', [
                            'column' => 'mi_type_UD_AD',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">
                        출금수
                        @include('Admin.Common.pair_button_arrow_sort_new', [
                            'column' => 'mi_type_UW_AW',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">
                        수익(입금-출금)
                        @include('Admin.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_revenue',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">
                        캐쉬
                        @include('Admin.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_cash',
                        ])
                    </td>
                    {{-- <td class="text-center bg-black-darker6">
                        포인트
                        @include('Admin.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_point',
                        ])
                    </td> --}}
                    <td class="text-center bg-black-darker6 width-270">간단메모</td>
                    <td class="text-center bg-black-darker6 p-0">이용허가</td>
                    <td class="text-center bg-black-darker6">세부</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    @include('Admin.Member.status_member_row', [
                        'member' => $member,
                        'includeDetail' => true,
                    ])
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="overunderline m-t-10"></div>
    @if ($members)
        <div class="text-center">
            {{ $members->appends(request()->query())->links('Admin.Common.pagination') }}
        </div>
    @endif
</div>
@section('custom-js')
    @vite([
        'resources/vite/js/page-create-member/create-member.js',
    ])
@endsection
