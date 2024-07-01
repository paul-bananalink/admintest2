@if ($paginator->hasPages())
    <div class="text-center flex-paginate">
        <div class="pagination-per-page mr-12">
            <select id="per-page" name="per_page"
                onchange="window.location.href = this.options[this.selectedIndex].getAttribute('data-action')">
                @foreach (config('constant_view.SELECT_PER_PAGE') as $key => $str)
                    <option @selected($paginator->perPage() == $key)
                        data-action="{{ request()->fullUrlWithQuery(['per_page' => $key, 'page' => 1]) }}">
                        {{ $str }}</option>
                @endforeach
            </select>
        </div>
        <ul class="spobull-pagination">
            @if ($paginator->onFirstPage())
                <li class="disabled"><a class="p-710" href="#"><i class="fa fa-angle-double-left"></i></a></li>
            @else
                <li><a class="p-710" href="{{ $paginator->previousPageUrl() }}"><i
                            class="fa fa-angle-double-left"></i></a></li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><a href="#">{{ $element }}</a></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><a href="#">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li><a class="p-710" href="{{ $paginator->nextPageUrl() }}"><i
                            class="fa fa-angle-double-right"></i></a></li>
            @else
                <li class="p-710" class="disabled"><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
            @endif
        </ul>
    </div>
@endif
