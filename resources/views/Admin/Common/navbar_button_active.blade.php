@php
    $badge = $badge ?? false;
@endphp
@if (Route::currentRouteName() == $routeName)
    <button class="btn btnstyle1-inverse2 f-s-11 actived">
        {!! $icon ?? '' !!} {{$text}}
        @if ($badge) <span class="badge badge-warning cst_badge">{{$number}}</span> @endif
    </button>
@else
    <a href="{{$routeURL}}" class="btn btnstyle1-inverse2 f-s-11">
        {!! $icon ?? '' !!} {{$text}}
        @if ($badge) <span class="badge badge-warning cst_badge">{{$number}}</span> @endif
    </a>
@endif
