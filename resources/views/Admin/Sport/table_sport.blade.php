<table class="table table-bordered cst-table-darkbrown">
    <thead>
        <tr>
            <th style="width: 40px">+a</th>
            <th style="width: 60px">종목</th>
            <th style="width: 12%">리그명</th>
            <th>홈팀(Home)</th>
            <th style="width: 70px">무(핸디)</th>
            <th>원정팀(Away)</th>
            <th style="width: 100px">배팅내역</th>
            <th style="width: 80px">배팅접수</th>
            <th style="width: 50px"></th>
            <th style="width: 40%">결과처리</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>
                    <div>
                        <p class="item-sport-point text-warning bg-blue-black border-solid-black mb-3 py-4">
                            +15
                        </p>
                        <p>
                            <a href="#" class="btnstyle1 btnstyle1-inverse2 h-31">
                                <i class="fa fa-eye text-blue-1" aria-hidden="true"></i>
                            </a>
                        </p>
                    </div>
                </td>
                <td>{{ $item->sports_name }}</td>
                <td class="text-left">
                    <div class="text-gray-3">{{ 'market_name' }}</div>
                    <div class="text-gray-3">{{ $item->game_time }}</div>
                    <div>{{ 'league_name' }}</div>
                </td>
                <td>
                    <div class="flex items-center">
                        <div class="text-center flex-1 mr-3">{{ $item->home_team }}</div>
                        <div class="w-60 bg-blue-black border-solid-black py-4">1.5</div>
                    </div>
                </td>
                <td>{{ $item->vs_team_sub ? $item->vs_team_sub : 'vs' }}</td>
                <td>
                    <div class="flex items-center">
                        <div class="w-60 bg-blue-black border-solid-black py-4">1.5</div>
                        <div class="text-center flex-1 mr-3">{{ $item->away_team }}</div>
                    </div>
                </td>
                <td><a href="#" class="btnstyle1 btnstyle1-inverse2 h-31 px-8">배팅내역</a></td>
                <td>
                    <div class="bg-green-4 border-solid-black radius-6 py-4">접수</div>
                </td>
                <td class="text-center"><img src="{{ asset('refresh.png') }}" width="16" class="cursor" data-id=""></td>
                <td>
                    @include('Admin.Sport.item_table_detail_sport')
                </td>
            </tr>
        @endforeach
    </tbody>
</table>