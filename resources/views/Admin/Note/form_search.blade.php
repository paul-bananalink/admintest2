<div class="panel-heading-btn-page">
    <form action="{{ route('admin.note.index') }}">
        <div class="btn-group">
            <select class="form-control input-sm search-input-box h-33 text-white width-full" name="search_by">
                <option value="member_id" @if( request('search_by') === 'member_id' ) selected @endif class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">아이디</option>
                <option value="content" @if( request('search_by') === 'content' ) selected @endif class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">전달내용</option>
            </select>
        </div>
        <div class="btn-group">
            <input placeholder="검색어입력" type="text" class="form-control input-sm width-200 search-input-box h-33 p-l-5 text-white" name="search_input" value="{{ request("search_input") }}">
        </div>
        <div class="btn-group">
            <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33 m-r-15">검색</button>
            <a href="{{ route('admin.note.index') }}" class="btnstyle1 btnstyle1-success h-31">전체</a>
            <a href="{{ route('admin.note.index', ['status' => 'read']) }}" class="btnstyle1 btnstyle1-primary h-31"><i class="fa fa-check" aria-hidden="true"></i> 읽음</a>
            <a href="{{ route('admin.note.index', ['status' => 'no_read']) }}" class="btnstyle1 btnstyle1-danger h-31"><i class="fa fa-exclamation" aria-hidden="true"></i> 안읽음</a>
        </div>
    </form>
</div>
