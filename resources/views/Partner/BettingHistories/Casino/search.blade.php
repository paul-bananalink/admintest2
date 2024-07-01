
<div class="panel-heading-btn-page align-right">
    <form action="{{ route('partner.betting-histories.casino') }}">
        <div>
            <div class="btn-group mb-6 mr-6">
                <div class="input-daterange h-33 bg-input">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <input id="js__single-start-date" name="start_date" value="{{ request('start_date') }}" type="text" placeholder="검색시작날짜" class="el-range-input h-31">
                    <span class="el-range-separator">To</span>
                    <input id="js__single-end-date" name="end_date" value="{{ request('end_date') }}" type="text" placeholder="검색마지막날짜" class="el-range-input h-31">
                </div>
            </div>
            <div class="btn-group mb-6">
                <select class="form-control input-sm search-input-box h-33 text-white w-100" name="provider">
                    <option value="">전체</option>
                    @foreach ($providers as $item)
                        <option @selected(request('provider') == $item->gpCode) value="{{ $item->gpCode }}">{{ $item->gpName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="btn-group mb-6">
                <input placeholder="넉네임, 파트너명" type="text" class="form-control input-sm w-152 search-input-box h-33 p-l-5 text-white" name="search_input" value="{{ request("search_input") }}">
            </div>
            <div class="btn-group mb-6">
                <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33 m-r-15">검색</button>
            </div>
            <div class="btn-group mb-6">
                <a href="#" class="btnstyle1 btnstyle1-white h-31">엑설저장</a>
            </div>
        </div>
    </form>
</div>
