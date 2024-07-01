<div class="panel-heading-btn-page">
    <form action="{{ route('admin.info-member-block.index') }}" method="GET">
        <div class="btn-group w-100">
            <select class="form-control input-sm search-input-box h-33 text-white width-full" name="">
                <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">전체</option>
            </select>
        </div>
        <div class="btn-group mr-12">
            <div class="input-daterange h-33 bg-input">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <input id="js__single-start-date" type="text" name="start_date" value="{{ request('start_date') }}"
                    placeholder="검색시작날짜" class="el-range-input h-31">
                <span class="el-range-separator">To</span>
                <input id="js__single-end-date" type="text" name="end_date" value="{{ request('end_date') }}"
                    placeholder="검색마지막날짜" class="el-range-input h-31">
            </div>
        </div>
        <div class="btn-group">
            <input placeholder="검색어입력" type="text"
                class="form-control input-sm w-80 search-input-box h-33 p-l-5 text-white" name="search_input"
                value="{{ request('search_input') }}">
        </div>
        <div class="btn-group">
            <button type="submit" class="btnstyle1 btnstyle1-success h-31">검색</button>
        </div>
    </form>
</div>
