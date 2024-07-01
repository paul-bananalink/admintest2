<div class="panel-heading-btn-page">
    <form action="">
        <div class="btn-group mr-12">
            <div class="input-daterange h-33 bg-input">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <input value="{{ request('start_date') }}" id="js__single-start-date" name="start_date" type="text"
                    placeholder="검색시작날짜" class="el-range-input h-31">
                <span class="el-range-separator">To</span>
                <input value="{{ request('end_date') }}" name="end_date" id="js__single-end-date" type="text"
                    placeholder="검색마지막날짜" class="el-range-input h-31">
            </div>
        </div>
        <div class="btn-group">
            <input placeholder="검색어입력" name="search" type="text"
                class="form-control input-sm w-80 search-input-box h-33 p-l-5 text-white"
                value="{{ request('search') }}">
        </div>
        <div class="btn-group">
            <button type="submit" class="btnstyle1 btnstyle1-success h-31">검색</button>
        </div>
    </form>
</div>
