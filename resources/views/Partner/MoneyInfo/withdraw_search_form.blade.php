<form action="{{ route('partner.money-info.index', ['type' => 'withdraw']) }}" method="GET">
    <div class="panel-heading-btn-page">
        <div class="btn-group mr-4">
            <div class="input-daterange h-33 bg-input">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <input id="js__single-start-date" name="start_date" value="{{ request('start_date') }}" type="text"
                    placeholder="검색시작날짜" class="el-range-input h-31">
                <span class="el-range-separator">To</span>
                <input id="js__single-end-date" name="end_date" value="{{ request('end_date') }}" type="text"
                    placeholder="검색마지막날짜" class="el-range-input h-31">
            </div>
        </div>
        <div class="btn-group w-50 mr-4">
            <select name="level" class="form-control input-sm search-input-box h-33 text-white width-full">
                <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">전체</option>
                @foreach (config('site_config.LEVELS') as $key => $value)
                    @php
                        $level = ++$key;
                        $selected = request('level') == $level ? 'selected' : '';
                    @endphp
                    <option value="{{ $level }}" class="p-5" @selected($selected)
                        style="border-bottom: 1px solid rgb(49, 65, 91);">
                        {{ $value }}레벨</option>
                @endforeach
            </select>
        </div>
        <div class="btn-group">
            <input placeholder="검색어입력" type="text"
                class="form-control input-sm w-80 search-input-box h-33 p-l-5 text-white" placeholder="닉네임, 따트너명, 예금주"
                name="search" value="{{ request('search') }}">
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="{{ request('filter') }}"
                class="btnstyle1 btnstyle1-inverse2 h-31">검색</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="all" class="btnstyle1 btnstyle1-success h-31">전체</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="requested" class="btnstyle1 btnstyle1-info h-31">처리대기</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="approved"
                class="btnstyle1 btnstyle1-primary h-31">처리완료</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="cancelled"
                class="btnstyle1 btnstyle1-danger h-31">취소처리</button>
        </div>
    </div>
</form>
