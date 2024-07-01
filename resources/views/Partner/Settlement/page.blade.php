@extends('Partner.page')


@section('content-child')
@yield('content-settlement')
@endsection

@section('custom-css')
<style>
    .group-search-cash .flex{
        display: flex;
    }
    .group-search-cash{
        margin: 20px 0px;
    }
    .group-search-cash .mr-2{
        margin-right: 8px;
    }
    .table-title {
        width: max-content;
        display: flex !important;
        justify-content: space-evenly;
    }
    .table-title-icon {
        display: flex;
        margin: 0 10px;
    }
    .max-w-50{
        max-width: 800px; 
    }
</style>
@endsection

@section('custom-js')
<script>
    $(document).ready(function () {
        let date = $('#js__single-date-cash').data('date');
        
        $("#js__single-date-cash").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: false,
            minYear: moment(),
            maxYear: parseInt(moment().format("YYYY"), 10),
            startDate: date !== '' ? date : false,
            autoUpdateInput: date !== '' ? true : false,
            locale: {
                format: "YYYY-MM-DD",
            },
        });
        $('#js__single-date-cash').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });

        $('#js__single-date-cash').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
@endsection
