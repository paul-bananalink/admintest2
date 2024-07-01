{{-- <a href="{{ route('admin.sport.index', ['type' => 'league']) }}" class="btn w-80 {{ $type == 'league' ? 'btn-inverse' : ''}}">리그</a> --}}

<div class="panel-heading-btn-page">
    <form action="{{ route('admin.sport.index', ['type' => $type]) }}">
        <div class="btn-group">
            <select class="form-control input-sm search-input-box h-33 text-white width-full" name="show">
                <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">전체</option>
                <option value="1" @if( request('show') === '1' ) selected @endif class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">노출</option>
                <option value="0" @if( request('show') === '0' ) selected @endif class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">비노출</option>
            </select>
        </div>
        <div class="btn-group">
            <input placeholder="검색어입력" type="text" class="form-control input-sm width-200 search-input-box h-33 p-l-5 text-white" name="search_input" value="{{ request("search_input") }}">
        </div>
        <div class="btn-group">
            <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33 m-r-15">검색</button>
            <a href="#" class="btnstyle1 btnstyle1-primary h-31">리그추가</a>
        </div>
    </form>
</div>
