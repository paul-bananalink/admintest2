<div class="panel-heading-btn-page">
    <form action="{{ route('admin.sport.index', ['type' => $type]) }}">
        <div class="btn-group">
            <input placeholder="검색어입력" type="text" class="form-control input-sm width-200 search-input-box h-33 p-l-5 text-white" name="search_input" value="{{ request("search_input") }}">
        </div>
        <div class="btn-group mr-32">
            <button type="submit" class="btnstyle1 btnstyle1-inverse3 h-33">검색</button>
        </div>
        <div class="btn-group">
            <div class="flex items-center pl-10 bg-blue-black border-solid-black off-switch-button">
                <span class="text-blue-1 mr-6">배팅경기</span>
                <div class="w-32">
                    <x-common.toggle_switch_button isCheck="1" id="id23"
                    name="id23"
                    urlAction=""
                    size="normal" />
                </div>
            </div>
        </div>
        <div class="btn-group mr-24">
            <a href="#" class="btnstyle1 btnstyle1-success h-31">진행 중경기</a>
        </div>

        <div class="btn-group">
            <div class="flex items-center pl-10 bg-blue-black border-solid-black off-switch-button">
                <span class="text-blue-1 mr-6">배팅경기</span>
                <div class="w-32">
                    <x-common.toggle_switch_button isCheck="1" id="id2"
                    name="id2"
                    urlAction=""
                    size="normal" />
                </div>
            </div>
        </div>
        <div class="btn-group mr-24">
            <a href="#" class="btnstyle1 btnstyle1-primary h-31">마감된경기</a>
        </div>

        <div class="btn-group">
            <div class="flex items-center pl-10 bg-blue-black border-solid-black off-switch-button">
                <span class="text-blue-1 mr-6">배팅경기</span>
                <div class="w-32">
                    <x-common.toggle_switch_button isCheck="1" id="id3"
                    name="id3"
                    urlAction=""
                    size="normal" />
                </div>
            </div>
        </div>
        <div class="btn-group mr-8">
            <a href="#" class="btnstyle1 btnstyle1-primary h-31">종료된경기</a>
        </div>
        <div class="btn-group">
            <a href="#" class="btnstyle1 btnstyle1-primary h-31">종료(수동)된경기</a>
        </div>
    </form>
</div>
