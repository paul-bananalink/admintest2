@isset($column)
    <div class="table-title-icon">
        @include('Admin.Member.button_arrow_sort', [
            'column' => $column,
            'sort' => config('constant_view.QUERY_DATABASE.DESC'),
        ])
        @include('Admin.Member.button_arrow_sort', [
            'column' => $column,
            'sort' => config('constant_view.QUERY_DATABASE.ASC'),
        ])
    </div>
@endisset
