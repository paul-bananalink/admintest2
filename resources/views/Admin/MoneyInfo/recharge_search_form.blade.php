<form action="{{ route('admin.money-info.index', ['type' => 'recharge']) }}" method="GET">
    @if ($is_rollback_mode && empty(request()->filter))
        <input type="hidden" name="mode" value="rollback">
    @endif
    <div class="panel-heading-btn-page">
        <div class="btn-group mr-4">
            <div class="input-daterange h-33 bg-input">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <input id="js__single-start-date" type="text" value="{{ request('start_date') }}" name="start_date"
                    placeholder="검색시작날짜" class="el-range-input h-31">
                <span class="el-range-separator">To</span>
                <input id="js__single-end-date" type="text" value="{{ request('end_date') }}" name="end_date"
                    placeholder="검색마지막날짜" class="el-range-input h-31">
            </div>
        </div>
        <div class="btn-group w-50 mr-4">
            <select class="form-control input-sm search-input-box h-33 text-white width-full" name="level">
                <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">전체</option>
                @foreach (config('site_config.LEVELS') as $key => $value)
                    @php
                        $level = ++$key;
                    @endphp
                    <option @selected($level == request('level')) value="{{ $level }}" class="p-5"
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
            <button class="btnstyle1 btnstyle1-inverse2 h-31" value="{{ request('filter') }}" name="filter"
                type="submit">검색</button> <!-- Search -->
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.money-info.export', ['type' => 'recharge', ...request()->query()]) }}"
                class="btnstyle1 btnstyle1-white h-31">액셀저장</a>

            <!-- Excel Save -->
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="all" class="btnstyle1 btnstyle1-success h-31">전체</button>
            <!-- All -->
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="requested" class="btnstyle1 btnstyle1-info h-31">처리대기</button>
            <!-- Processing -->
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="approved"
                class="btnstyle1 btnstyle1-primary h-31">처리완료</button> <!-- Processed -->
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="cancelled"
                class="btnstyle1 btnstyle1-danger h-31">취소처리</button>
            <!-- Cancel -->
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="rollback"
                class="btnstyle1 btnstyle1-warning h-31">환수처리</button>
        </div>
        <div class="btn-group">
            <a href="#" data-html="true"
                class="btnstyle1 btnstyle1-danger h-31"data-content="<ul class='popover-rollback'><li><a href='{{ route('admin.money-info.index', ['type' => 'recharge']) }}'>일반모드</a></li><li><a href='{{ route('admin.money-info.index', ['type' => 'recharge', 'mode' => 'rollback']) }}'>수정(롤백)모드</a></li></ul>"
                data-toggle="popover" data-placement="bottom" data-content="Content">
                @if ($is_rollback_mode)
                    수정(롤백)모드
                @else
                    일반모드
                @endif
                <i class="fa fa-angle-down"></i>
            </a>
        </div>
    </div>
</form>
