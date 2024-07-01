<form action="{{ route('admin.money-info.index', ['type' => 'recharge']) }}" method="GET">

    <div class="panel-heading-btn-page">
        <div class="btn-group w-80 mr-4">
            <select class="form-control input-sm search-input-box h-33 text-white width-full" name="level">
                <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">아이디</option>
                <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">파트너명</option>
                <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">닉네임</option>

            </select>
        </div>
        <div class="btn-group">
            <input placeholder="검색어입력" type="text"
                class="form-control input-sm w-80 search-input-box h-33 p-l-5 text-white" placeholder="검색어입력"
                name="search" value="{{ request('search') }}">
        </div>
        <div class="btn-group">
            <button class="btnstyle1 btnstyle1-success h-31" value="{{ request('filter') }}" name="filter"
                type="submit">검색</button> <!-- Search -->
            <button class="btnstyle1 btnstyle1-primary h-31" value="{{ request('filter') }}" name="filter"
                type="submit">현황</button> <!-- Search -->
            <button class="btnstyle1 btnstyle1-inverse2 h-31" value="{{ request('filter') }}" name="filter"
                type="submit">내역</button> <!-- Search -->
            <button class="btnstyle1 btnstyle1-inverse2 h-31" value="{{ request('filter') }}" name="filter"
                type="submit">일괄지급</button> <!-- Search -->
        </div>
    </div>
</form>
