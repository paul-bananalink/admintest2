<form action="{{route('admin.popup.index')}}">
    <div class="panel-heading-btn-page">
        <div class="btn-group">
            <input placeholder="검색어입력" type="text" class="form-control input-sm width-200 search-input-box h-33 p-l-5 text-white" name="search_input" value="{{ request("search_input") }}">
        </div>
        <div class="btn-group">
            <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33 m-r-15">검색</button>
            <a href="{{route('admin.popup.index', [...request()->query()])}}" class="btnstyle1 btnstyle1-success h-31">전체</a>
            <a href="{{route('admin.popup.index', [...request()->query(), 'filter' => 'poUsed'])}}" class="btnstyle1 btnstyle1-primary h-31"><i class="fa fa-check" aria-hidden="true"></i>사용중</a>
            <a href="{{route('admin.popup.index', [...request()->query(), 'filter' => 'poNotUsed'])}}" class="btnstyle1 btnstyle1-danger h-31 mr-32"><i class="fa fa-exclamation" aria-hidden="true"></i>사용안함</a>
            <a href="{{route('admin.popup.index', [...request()->query(), 'filter' => 'poOpenNewWindow'])}}" class="btnstyle1 btnstyle1-primary h-31"><i class="fa fa-plus" aria-hidden="true"></i> 팝업창추가</a>
        </div>
        <input type="hidden" name="filter" value="{{ request('filter') }}">
    </div>
</form>