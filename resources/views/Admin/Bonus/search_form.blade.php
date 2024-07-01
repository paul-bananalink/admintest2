<div class="panel-heading-btn-page max-w-65-per align-right">
    <form action="{{ route('admin.bonus.index') }}" method="GET">
        <div>
            <div class="btn-group mr-4 mb-3">
                <div class="input-daterange h-33 bg-input">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <input id="js__single-start-date" name="start_date" value="{{ request('start_date') }}" type="text"
                        placeholder="검색시작날짜" class="el-range-input h-31">
                    <span class="el-range-separator">To</span>
                    <input id="js__single-end-date" name="end_date" value="{{ request('end_date') }}" type="text"
                        placeholder="검색마지막날짜" class="el-range-input h-31">
                </div>
            </div>
            <div class="btn-group mb-3">
                <input type="text" class="form-control input-sm w-100 search-input-box h-33 p-l-5 text-white"
                    placeholder="닉네임, 파트너명" name="search" value="{{ request('search') }}">
            </div>
            <div class="btn-group mb-3">
                <button type="submit" name="filter" value="{{ request('filter') }}"
                    class="btnstyle1 btnstyle1-success height-31">검색</button>
            </div>
            <div class="btn-group">
                <button type="submit" name="filter" value="bonus_all" @class([
                    'btnstyle1-primary' => request('filter') == null || request('filter') == 'bonus_all',
                    'btnstyle1 height-30 btnstyle1-inverse2 mb-3',
                ])>
                    전체
                </button>
                <button type="submit" name="filter" value="sports_first_time_bonus" @class([
                    'btnstyle1-primary' => request('filter') == 'sports_first_time_bonus',
                    'btnstyle1 height-30 btnstyle1-inverse2 mb-3',
                ])>
                    스포츠첫충전
                </button>
                <button type="submit" name="filter" value="sports_next_time_bonus" @class([
                    'btnstyle1-primary' => request('filter') == 'sports_next_time_bonus',
                    'btnstyle1 height-30 btnstyle1-inverse2 mb-3',
                ])>
                    스포츠매충전
                </button>
                <button type="submit" name="filter" value="casino_first_time_bonus" @class([
                    'btnstyle1-primary' => request('filter') == 'casino_first_time_bonus',
                    'btnstyle1 height-30 btnstyle1-inverse2 mb-3',
                ])>
                    카지노첫충전
                </button>
                <button type="submit" name="filter" value="casino_next_time_bonus" @class([
                    'btnstyle1-primary' => request('filter') == 'casino_next_time_bonus',
                    'btnstyle1 height-30 btnstyle1-inverse2 mb-3',
                ])>
                    카지노매충전
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    포커첫충전
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    포커매충전
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    출석현황1
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    출석현황2
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    명예의 전당
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    지인추천1-1
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    지인추천1-2
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    지인추천2
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    관리자
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    가입머니
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    입풀
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    레벨업
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    페이백
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    롤링포인트
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    낙첨포인트
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    위로금
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    파트너롤링 쉐어
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    월출석현황
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    쿠폰
                </button>
            </div>
        </div>
    </form>
</div>
