<div class="panel-heading-btn-page">
    <form action="{{ route('admin.sport.index', ['type' => $type]) }}">
        <div class="btn-group">
            <select name="" class="form-control input-sm search-input-box h-33 text-white" id="">
                <option value="">전체검색</option>
            </select>
        </div>
        <div class="btn-group">
            <input placeholder="검색어입력" type="text" class="form-control input-sm width-200 search-input-box h-33 p-l-5 text-white" name="search_input" value="{{ request("search_input") }}">
        </div>
        <div class="btn-group mr-32">
            <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33">검색</button>
        </div>

        <div class="btn-group">
            <a class="btnstyle1 btnstyle1-success h-31">진행 중경기</a>
            <a class="btnstyle1 btnstyle1-primary h-31">대기중경기</a>
            <a class="btnstyle1 btnstyle1-primary h-31">종료된경기</a>
            <a class="btnstyle1 btnstyle1-primary h-31">종료(수동)된경기</a>
        </div>
    </form>
</div>
