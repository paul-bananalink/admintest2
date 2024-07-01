<form action="{{ route('partner.point-history.index') }}" method="GET">
    <div class="panel-heading-btn-page">
        <div class="btn-group mr-4">
            <div class="input-daterange h-33 bg-input">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <input id="js__single-start-date" name="start_date" value="{{ request('start_date') }}" type="text"
                    placeholder="검색시작날짜" class="el-range-input h-31">
                <span class="el-range-separator">To</span>
                <input id="js__single-end-date" name="end_date" value="{{ request('end_date') }}" type="text"
                    placeholder="검색마지막날짜" class="el-range-input h-31">
            </div>
        </div>
        <div class="btn-group w-60 mr-4">
            <select name="level" class="form-control input-sm search-input-box h-33 text-white width-full">
                <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">전체</option>
                @foreach (config('site_config.LEVELS') as $key => $value)
                    @php
                        $level = ++$key;
                        $selected = request('level') == $level ? 'selected' : '';
                    @endphp
                    <option value="{{ $level }}" class="p-5" @selected($selected)
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
        <div class="btn-group mr-12">
            <button type="submit" name="filter" value="{{ request('filter') }}"
                class="btnstyle1 btnstyle1-success h-31">검색</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="all"
                class="btnstyle1 {{ !request('filter') || request('filter') == 'all' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">전체</button>
        </div>
        {{-- <div class="btn-group">
            <button type="submit" name="filter" value="sports"
                class="btnstyle1 {{ request('filter') == 'sports' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">스포츠머니</button>
        </div> --}}
        <div class="btn-group">
            <button type="submit" name="filter" value="casino_slot"
                class="btnstyle1 {{ request('filter') == 'casino_slot' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">카지노머니</button>
        </div>
        {{-- <div class="btn-group">
            <button type="submit" name="filter" value="temp1 poker"
                class="btnstyle1 {{ request('filter') == 'temp1' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">포커머니</button>
        </div> --}}
        <div class="btn-group">
            <button type="submit" name="filter" value="UD"
                class="btnstyle1 {{ request('filter') == 'UD' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">입금</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="UW"
                class="btnstyle1 {{ request('filter') == 'UW' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">출금</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="temp2 compensation"
                class="btnstyle1 {{ request('filter') == 'temp2' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">환수</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="temp3 transfer_money"
                class="btnstyle1 {{ request('filter') == 'temp3 transfer_money' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">머니이동</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="miBonusPercent"
                class="btnstyle1 {{ request('filter') == 'miBonusPercent' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">보너스</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="Bet"
                class="btnstyle1 {{ request('filter') == 'Bet' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">배팅</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="CancelBet"
                class="btnstyle1 {{ request('filter') == 'CancelBet' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">배팅취소</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="Win"
                class="btnstyle1 {{ request('filter') == 'Win' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">당첨</button>
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="temp4 director"
                class="btnstyle1 {{ request('filter') == 'temp4 director' ? 'btnstyle1-primary' : 'btnstyle1-inverse2' }} h-31">관리자</button>
        </div>
        <form action="{{ route('partner.money-info.update-ids', ['type' => 'withdraw']) }}" method="post"
            id="update_ids">
            @csrf
        </form>
    </div>
</form>
