<div class="panel-heading-btn-page max-w-65-per align-right">
    <form action="{{ route('admin.point-history.index') }}" method="GET">
        <div class="panel-heading-btn-page">
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
                    is_null(request('filter')) || request('filter') == 'bonus_all'
                        ? 'btnstyle1-primary'
                        : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    전체
                </button>
                <button type="submit" name="filter" value="recharge_bonus" @class([
                    request('filter') == 'recharge_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    충전
                </button>
                <button type="submit" name="filter" value="sports_first_time_bonus" @class([
                    request('filter') == 'sports_first_time_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    스포츠첫충전
                </button>
                <button type="submit" name="filter" value="sports_next_time_bonus" @class([
                    request('filter') == 'sports_next_time_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    스포츠매충전
                </button>
                <button type="submit" name="filter" value="casino_first_time_recharge_bonus" @class([
                    request('filter') == 'casino_first_time_recharge_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    카지노첫충전
                </button>
                <button type="submit" name="filter" value="casino_next_time_recharge_bonus" @class([
                    request('filter') == 'casino_next_time_recharge_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    카지노매충전
                </button>

                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    포커첫충전
                </button>
                <button type="button" class="btnstyle1 height-30 btnstyle1-inverse2 mb-3">
                    포커매충전
                </button>
                <button type="submit" name="filter" value="signup_bonus" @class([
                    request('filter') == 'signup_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    가입머니
                </button>
                <button type="submit" name="filter" value="participate_bonus" @class([
                    request('filter') == 'participate_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    입플
                </button>
                <button type="submit" name="filter" value="new_member_bonus" @class([
                    request('filter') == 'new_member_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    신규
                </button>
                <button type="submit" name="filter" value="attendance_bonus" @class([
                    request('filter') == 'attendance_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    출석현황
                </button>
                <button type="submit" name="filter" value="referral_1_bonus" @class([
                    request('filter') == 'referral_1_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    지인추천1
                </button>
                <button type="submit" name="filter" value="referral_2_bonus" @class([
                    request('filter') == 'referral_2_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    지인추천2
                </button>
                <button type="submit" name="filter" value="hall_of_fame_bonus" @class([
                    request('filter') == 'hall_of_fame_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    명예의 전당
                </button>
                <button type="submit" name="filter" value="consolation_prize_bonus" @class([
                    request('filter') == 'consolation_prize_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    위로금
                </button>
                <button type="submit" name="filter" value="payback_bonus" @class([
                    request('filter') == 'payback_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    페이백
                </button>
                <button type="submit" name="filter" value="rolling_bonus" @class([
                    request('filter') == 'rolling_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    롤링포인트
                </button>
                <!-- TODO:SADSAD -->
                {{-- <button type="submit" name="filter" value="losing_bonus" @class([
                    request('filter') == 'losing_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    낙첨포인트 2222
                </button> --}}
                {{-- <button type="submit" name="filter" value="level_up_bonus" @class([
                    request('filter') == 'level_up_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    레벨업
                </button> --}}
                <button type="submit" name="filter" value="coupon_and_payment_bonus" @class([
                    request('filter') == 'coupon_and_payment_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    쿠폰현황 및 지급
                </button>
                <button type="submit" name="filter" value="sudden_bonus" @class([
                    request('filter') == 'sudden_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    돌발보너스
                </button>
                <!-- TODO:SADSAD -->
                {{-- <button type="submit" name="filter" value="partner_share_bonus" @class([
                    request('filter') == 'partner_share_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    파트너롤링 쉐어 2222
                </button> --}}
                <button type="submit" name="filter" value="monthly_attendance_bonus" @class([
                    request('filter') == 'monthly_attendance_bonus' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    월출석현황
                </button>
                <button type="submit" name="filter" value="admin_recharge" @class([
                    request('filter') == 'admin_recharge' ? 'btnstyle1-primary' : 'btnstyle1-inverse2',
                    'btnstyle1 height-30 mb-3',
                ])>
                    관리자지급
                </button>
            </div>
        </div>
    </form>
</div>
