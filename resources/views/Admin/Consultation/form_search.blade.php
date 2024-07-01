{{-- <div>
    <form action="{{ route('admin.consultation.index') }}" method="get">
        <div class="flex group-search">
            <div class="flex">
                <input id="js__two-calendar-cons" class="form-control mr-2" name="date_search" type="text" placeholder="날짜 선택" value="{{ request('date_search') }}">
                <input type="text" class="form-control mr-2" name="input_search" value="{{ request('input_search') }}" placeholder="내용 검색">
                <button type="submit" class="btn btn-inverse">검색</button>
            </div>
        </div>
    </form>
</div> --}}

<div class="panel-heading-btn-page">
    <form action="{{ route('admin.consultation.index') }}">
        <div class="btn-group mr-4">
            <div class="input-daterange h-33 bg-input">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <input id="js__single-start-date" name="start_date" value="{{ request('start_date') }}" type="text" placeholder="검색시작날짜" class="el-range-input h-31">
                <span class="el-range-separator">To</span>
                <input id="js__single-end-date" name="end_date" value="{{ request('end_date') }}" type="text" placeholder="검색마지막날짜" class="el-range-input h-31">
            </div>
        </div>
        <div class="btn-group">
            <select class="form-control input-sm search-input-box h-33 text-white w-144" name="mLevel">
                <option value="">회원레벨</option>
                @foreach (config("site_config.LEVELS") as $level)
                    <option @if(request('mLevel') == $level) selected @endif value="{{$level}}">{{$level}}레벨</option>
                @endforeach
            </select>
        </div>
        <div class="btn-group">
            <input placeholder="검색어입력" type="text" class="form-control input-sm width-200 search-input-box h-33 p-l-5 text-white" name="search_input" value="{{ request("search_input") }}">
        </div>
        <div class="btn-group">
            <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33 m-r-15">검색</button>
            <a href="{{ route(Route::currentRouteName(), [...request()->query(), 'type' => 2]) }}" class="btnstyle1 btnstyle1-primary h-31">답변완료</a>
            <a href="{{ route(Route::currentRouteName(), [...request()->query(), 'type' => 1]) }}" class="btnstyle1 btnstyle1-danger h-31">미답변</a>
        </div>

        <input type="hidden" name="type" value="{{ request("type") }}">
    </form>
</div>
