
<div class="panel-heading-btn-page align-right">
    <form action="#">
        <div>
            <div class="btn-group mb-6 mr-6">
                <div class="input-daterange h-33 bg-input">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <input id="js__single-start-date" name="start_date" id="start-date" name="start_date" value="{{ old('start_date') }}" type="text" placeholder="검색시작날짜" class="el-range-input h-31">

                    <span class="el-range-separator">To</span>
                    <input id="js__single-end-date" id="end-date" name="end_date" value="{{ old('end_date') }}" type="text" placeholder="검색마지막날짜" class="el-range-input h-31">
                </div>
            </div>
            <div class="btn-group mb-6">
                <input placeholder="검색어입력" type="text" class="form-control input-sm w-152 search-input-box h-33 p-l-5 text-white" name="mID_tRoundId_gpName" value="">
            </div>
            <div class="btn-group mb-6">
                <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33 m-r-15">검색</button>
            </div>
            <div class="btn-group mb-6">
                <a href="#" class="btnstyle1 btnstyle1-primary h-31 w-60">당첨</a>
                <a href="#" class="btnstyle1 btnstyle1-danger h-31 w-60">낙첨</a>
            </div>
        </div>
    </form>
</div>

