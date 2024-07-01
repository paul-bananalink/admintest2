{{-- <a href="{{ route('admin.sport.index', ['type' => 'league']) }}" class="btn w-80 {{ $type == 'league' ? 'btn-inverse' : ''}}">리그</a> --}}

<div class="panel-heading-btn-page">
    <form action="{{ route('admin.sport.index', ['type' => $type]) }}">
        <div class="btn-group">
            <input placeholder="검색어입력" type="text" class="form-control input-sm width-200 search-input-box h-33 p-l-5 text-white" name="search_input" value="{{ request("search_input") }}">
        </div>
        <div class="btn-group">
            <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33">검색</button>
        </div>
    </form>
</div>
