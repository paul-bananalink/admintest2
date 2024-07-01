<div class="panel-heading-btn-page">
    <form action="#">
        <div class="btn-group mr-3">
            <div class="input-daterange h-33 bg-input">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <input id="js__single-start-date" name="start_date" value="{{ request('start_date') }}" type="text" placeholder="검색시작날짜" class="el-range-input h-31">
                <span class="el-range-separator">To</span>
                <input id="js__single-end-date" name="end_date" value="{{ request('end_date') }}" type="text" placeholder="검색마지막날짜" class="el-range-input h-31">
            </div>
        </div>
        <div class="btn-group">
            <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33 mr-12">검색</button>

            <a href="#" class="btnstyle1 btnstyle1-success h-31">전체</a>
            <a href="#" class="btnstyle1 btnstyle1-primary h-31">정상활동</a>
            <a href="#" class="btnstyle1 btnstyle1-primary h-31 mr-12">활동중지</a>

            <button type="button" data-toggle="collapse" data-target="#MEMBER_CSEP_MAKE" class="btnstyle1 btnstyle1-primary h-31" aria-expanded="true"><i class="fa ion-android-contacts text-white2 f-s-20"></i> 파트너등록
            </button>
        </div>

        <input type="hidden" name="type" value="{{ request("type") }}">
    </form>
</div>