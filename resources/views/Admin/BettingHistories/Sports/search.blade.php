
<div class="panel-heading-btn-page max-w-65-per align-right">
    <form action="#">
        <div>
            <div class="btn-group mb-6 mr-6">
                <div class="input-daterange h-33 bg-input">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <input id="js__single-start-date" name="start_date" value="{{ request('start_date') }}" type="text" placeholder="검색시작날짜" class="el-range-input h-31">
                    <span class="el-range-separator">To</span>
                    <input id="js__single-end-date" name="end_date" value="{{ request('end_date') }}" type="text" placeholder="검색마지막날짜" class="el-range-input h-31">
                </div>
            </div>
            <div class="btn-group mb-6 mr-12">
                <a href="#" class="btnstyle1 btnstyle1-success h-31"><i class="fa fa-long-arrow-down" aria-hidden="true"></i> 버팅시간</a>
                <a href="#" class="btnstyle1 btnstyle1-success h-31"><i class="fa fa-long-arrow-down" aria-hidden="true"></i> 배팅금액</a>
                <a href="#" class="btnstyle1 btnstyle1-success h-31"><i class="fa fa-long-arrow-down" aria-hidden="true"></i> 예상당첨금액</a>
            </div>
            <div class="btn-group mb-6">
                <select class="form-control input-sm search-input-box h-33 text-white w-70" name="">
                    <option value="">전체</option>
                </select>
            </div>
            <div class="btn-group mb-6">
                <input placeholder="검색어입력" type="text" class="form-control input-sm w-100 search-input-box h-33 p-l-5 text-white" name="search_input" value="{{ request("search_input") }}">
            </div>
            <div class="btn-group mb-6">
                <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33 m-r-15">검색</button>
            </div>
            <div class="btn-group mb-6">
                <div class="flex items-center ">
                    <div class="text-light mr-3">폴더수:</div>
                    <select class="form-control input-sm search-input-box h-33 text-white w-144" name="">
                        <option value="">전체</option>
                    </select>
                </div>
            </div>
        </div>
        <div>
            <div class="btn-group mb-6 mr-6">
                <div class="flex">
                    <div class="w-100 mr-6">
                        <x-common.toggle_switch_button content="테스트유저 노출" contentOff="테스트유저 비노출"
                        isCheck="{{ false }}" id="test"
                        name="test"
                        urlAction=""
                        size="big" />
                    </div>
                    <div class="w-100">
                        <x-common.toggle_switch_button content="전체" contentOff="주의회원"
                        isCheck="{{ true }}" id="test1"
                        name="test1"
                        urlAction=""
                        size="big" />
                    </div>
                </div>
            </div>
            <div class="btn-group mb-6 mr-12">
                <a href="#" class="btnstyle1 btnstyle1-info h-31"><i class="fa fa-check text-dark" aria-hidden="true"></i> 정산대기</a>
                <a href="#" class="btnstyle1 btnstyle1-danger h-31">배팅취소</a>

                <a href="#" class="btnstyle1 btnstyle1-primary h-31 w-60">당첨</a>
                <a href="#" class="btnstyle1 btnstyle1-danger h-31 w-60">낙첨</a>
                <a href="#" class="btnstyle1 btnstyle1-warning h-31 w-60 mr-12">적특</a>

                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-12">정산완료</a>

                <a href="#" class="btnstyle1 btnstyle1-danger h-31">이상발생</a>
                <a href="#" class="btnstyle1 btnstyle1-warning h-31">난경기</a>
            </div>
            <div class="btn-group mb-6">
                <select class="form-control input-sm search-input-box h-33 text-white w-100 bg-red-1" name="">
                    <option value="">수정모드</option>
                </select>
            </div>
        </div>
    </form>
</div>
