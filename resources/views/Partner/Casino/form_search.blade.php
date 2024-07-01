<div>
    <form action="{{ route('partner.game.index', ['type' => $type]) }}">
        <div class="box-category">
            <ul>
                @if (!$providers->isEmpty())
                    <li><a class="box-title {{ $paramSearch['gpCode'] == "" ? 'orange' : 'text-light' }}" href="{{ route('partner.game.index', ['type' => $type]) }}">전체</a></li>
                @endif
                @foreach ($providers as $item)
                    <li><a class="box-title {{ $paramSearch['gpCode'] == $item->gpCode ? 'orange' : 'text-light' }}" href="{{ route('partner.game.index', ['type' => $type, 'gpCode' => $item->gpCode]) }}">{{ $item->gpName }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="flex group-search-casino">
            <ul id="add-time" class="time-group-search flex">
                <li><a href="#" class="btn {{ $paramSearch['actived_time'] === $paramSearch['today'] ? 'btn-inverse' : ''  }}" data-date-start="{{ $paramSearch['today'] }}">오늘</a></li>
                <li><a href="#" class="btn {{ $paramSearch['actived_time'] === $paramSearch['one_week'] ? 'btn-inverse' : ''  }}"  data-date-start="{{ $paramSearch['one_week'] }}">1주일</a></li>
                <li><a href="#" class="btn {{ $paramSearch['actived_time'] === $paramSearch['half_month'] ? 'btn-inverse' : ''  }}"  data-date-start="{{ $paramSearch['half_month'] }}">15일</a></li>
                <li><a href="#" class="btn {{ $paramSearch['actived_time'] === $paramSearch['one_month'] ? 'btn-inverse' : ''  }}"  data-date-start="{{ $paramSearch['one_month'] }}">1달</a></li>
                <li><a href="#" class="btn {{ $paramSearch['actived_time'] === $paramSearch['three_month'] ? 'btn-inverse' : ''  }}"  data-date-start="{{ $paramSearch['three_month'] }}">3달</a></li>
            </ul> 
            <div class="flex">
                <input id="js__two-calendar" class="form-control" name="start_and_end_date" type="text" data-start="{{ $paramSearch['actived_time'] }}" data-end="{{ $paramSearch['end_date'] }}">
                <input type="text" class="form-control" name="mID_tRoundId_gpName" value="{{ $paramSearch['mID_tRoundId_gpName'] }}">
                <input type="hidden" name="gpCode" value="{{ $paramSearch['gpCode'] }}">
                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> 검색</button>
            </div>
        </div>
    </form>
</div>