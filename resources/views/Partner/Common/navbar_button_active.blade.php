@php
    $badge = $badge ?? false;
@endphp
@if (Route::currentRouteName() == $routeName)
    <button class="btn btn-inverse btn-sm">
        <i class="fa fa-edit"></i> {{$text}}
        @if ($badge) <span class="badge badge-warning cst_badge">{{$number}}</span> @endif
    </button>
@else
    <a href="{{$routeURL}}" class="btn btn-gray btn-sm">
        <i class="fa fa-edit"></i> {{$text}}
        @if ($badge) <span class="badge badge-warning cst_badge">{{$number}}</span> @endif
    </a>
@endif
