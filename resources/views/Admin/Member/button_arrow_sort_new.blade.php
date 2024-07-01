<a href="{{ route(Route::currentRouteName(), [...request()->all(), 'orderBy' => $column, 'sort' => $sort]) }}">
    <i
        class="fa fa-sort-amount-{{ $icon }} pull-right m-t-1 f-s-15 text-white cursor @if (!$enable) alpha-40 @endif"></i>
</a>
