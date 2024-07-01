<a class="btn_arrow"
    href="{{ route(Route::currentRouteName(), [...request()->all(), 'orderBy' => $column, 'sort' => $sort]) }}">
    @if ($sort == config('constant_view.QUERY_DATABASE.DESC'))
        <i class="glyphicon glyphicon-arrow-down @if ($column == request('orderBy') && $sort == request('sort')) gray @else red @endif"></i>
    @elseif ($sort == config('constant_view.QUERY_DATABASE.ASC'))
        <i class="glyphicon glyphicon-arrow-up @if ($column == request('orderBy') && $sort == request('sort')) gray @else blue @endif"></i>
    @endif
</a>
