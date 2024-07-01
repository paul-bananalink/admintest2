<div>
    <form action="{{ route('partner.settlement.index') }}" method="get">
        <div class="flex group-search-cash">
            <div class="flex">
                <input type="text" class="form-control mr-2" name="mID" value="{{ request('mID') }}" placeholder="아이디를">
                <input id="js__single-date-cash" class="form-control mr-2" name="date_search" type="text" placeholder="날짜 검색" data-date="{{ request('date_search') }}">
                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> 검색</button>
            </div>
        </div>
    </form>
</div>