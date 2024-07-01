<div class="animated fadeInUp panel panel-inverse bg-black-darker2 p-0">
    <div class="panel-heading p-b-13" style="background: rgb(0, 34, 68)">
        <form action="{{ route('partner.status-members.index') }}" method="get">
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
                <button class="btnstyle1 btnstyle1-inverse3 btnstyle1-sm height-33 m-l-5" style="float: left"
                    type="submit" name="btn_submit" value="click">
                    검색
                </button>
            </div>
        </form>
        <div class="panel-heading-btn flex items-center">
            <div class="btn-group m-l-1 m-r-2">
                <button type="button" class="btnstyle1 btnstyle1-info btnstyle1-sm height-31 m-r-10">
                    실입금자(0)
                </button>
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
            </div>
        </div>
        <h4 class="panel-title m-5">
            <strong><i class="fa fa-arrow-down"></i> MEMBER LIST :: 회원 </strong>
        </h4>
    </div>
    <div class="no-bg m-t-10">
        <table id="RegMemberTable" class="table table-bordered table-td-valign-middle text-center text-white no-bg">
            <thead>
                <tr>
                    <td class="text-center bg-black-darker6">순번</td>
                    <td class="text-center bg-black-darker6 p-0">상태</td>
                    <td class="text-center bg-black-darker6">파트너명</td>
                    <td class="text-center bg-black-darker6">
                        가입일
                        @include('Partner.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_register_date',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">
                        접속일
                        @include('Partner.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_login_date_time',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">레벨</td>
                    <td class="text-center bg-black-darker6 width-150">
                        아이디
                    </td>
                    <td class="text-center bg-black-darker6">닉네임</td>
                    <td class="text-center bg-black-darker6">이름</td>
                    <td class="text-center bg-black-darker6">
                        입금수
                        @include('Partner.Common.pair_button_arrow_sort_new', [
                            'column' => 'mi_type_UD_AD',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">
                        출금수
                        @include('Partner.Common.pair_button_arrow_sort_new', [
                            'column' => 'mi_type_UW_AW',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">
                        수익(입금-출금)
                        @include('Partner.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_revenue',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">
                        캐쉬
                        @include('Partner.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_cash',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6">
                        포인트
                        @include('Partner.Common.pair_button_arrow_sort_new', [
                            'column' => 'm_point',
                        ])
                    </td>
                    <td class="text-center bg-black-darker6 width-270">쿠폰관리</td>
                    <td class="text-center bg-black-darker6">간단메모</td>
                    {{-- <td class="text-center bg-black-darker6 p-0">이용허가</td> --}}
                    {{-- <td class="text-center bg-black-darker6">세부</td> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $index => $member)
                    @include('Partner.Member.status_member_row', [
                        'member' => $member,
                        'index' => $index,
                        'includeDetail' => true,
                    ])
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="overunderline m-t-10"></div>
    <div class="text-center">
        @if ($members)
            <div class="text-center">
                {{ $members->appends(request()->query())->links('Admin.Common.pagination') }}
            </div>
        @endif
    </div>
</div>
