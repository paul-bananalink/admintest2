import createToast from '../toast/script'
import { formDataToObject, fetchData, parseNumberToDecimal, setNumberPhone } from '../functions.js'

$(document).ready(function() {
    $("#js__single-date-cash").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: false,
        startDate: false,
        autoUpdateInput: false,
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

$(document).on('show.bs.collapse', '.settlement-web-detail', (e) => {
    if ($(e.target).hasClass('settlement-web-detail')) {
        let $loadingBar = $('<div class="loading-bar"><div class="bar"></div></div>');
        $(e.target).html($loadingBar);

        let url = $(e.target).data('url');
        console.log(url);
        fetchData(url, "get").then((data) => {
            $(e.target).collapse('show');
            $(e.target).html(data.data);

            $('html, body').animate({
                scrollTop: $(e.target).offset().top - $('.navbar-fixed-c').height() - 100
            }, 500)
        });
    }
});

$(document).on('shown.bs.collapse', '.settlement-web-history', (e) => {
    $('html, body').animate({
        scrollTop: $(e.target).offset().top - $('.navbar-fixed-c').height() - 100
    }, 500)
});

$(document).on('hidden.bs.collapse', '.settlement-web-detail', (e) => {
    if ($(e.target).hasClass('settlement-web-detail')) {
        $(e.target).empty();
    }
});

$(document).on('click', '.open-settlement-detail', (e) => {
    const $target = $(e.target).closest('.open-settlement-detail');
    $target.addClass('d-none');
    $target.siblings('.close-settlement-detail').removeClass('d-none');
});

$(document).on('click', '.close-settlement-detail', (e) => {
    const $target = $(e.target).closest('.close-settlement-detail');
    const dataSelector = $target.data('data');
    $target.addClass('d-none');
    $target.siblings('.open-settlement-detail').removeClass('d-none');
    $('tr[class*="' + dataSelector + '"].child').remove();
});

$(document).on("show.bs.collapse", ".settlement-detail", (e) => {
    let $loadingBar = $(
        '<div class="loading-bar"><div class="bar"></div></div>'
    );
    $(e.target).html($loadingBar);

    let url = $(e.target).data("url");
    fetchData(url, "get").then((data) => {
        // $(".settlement-detail").not(e.target).collapse("hide");
        $(e.target).collapse("show");
        $(e.target).html($(data.data).not('.child').html());
        $(e.target).after($(data.data).not('.detail'));
    });
});

$(document).on("hidden.bs.collapse", ".settlement-detail", (e) => {
    $(e.target).empty();
});
