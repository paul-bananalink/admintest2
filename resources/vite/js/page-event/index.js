
// Start date event
$(".js__start-date-event").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: false,
    minYear: moment(),
    maxYear: parseInt(moment().format("YYYY"), 10),
    startDate: $(this).val(),
    autoUpdateInput: false,
    locale: {
        format: "YYYY-MM-DD",
    },
});

$('.js__start-date-event').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});

$('.js__start-date-event').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
});

// End date event
$(".js__end-date-event").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: false,
    minYear: moment(),
    maxYear: parseInt(moment().format("YYYY"), 10),
    startDate: $(this).val(),
    autoUpdateInput: false,
    locale: {
        format: "YYYY-MM-DD",
    },
});

$('.js__end-date-event').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});

$('.js__end-date-event').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
});

$(".js__single-date-newb").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: true,
    minYear: moment(),
    maxYear: parseInt(moment().format("YYYY"), 10),
    startDate: $(this).val(),
    autoUpdateInput: true,
    locale: {
        format: "YYYY-MM-DD HH:mm:ss",
    },
});

$('.js__single-date-newb').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD' + ' ' + 'HH:mm:ss'));
});


$(".js__single-date-newb-create").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: true,
    minYear: moment(),
    maxYear: parseInt(moment().format("YYYY"), 10),
    startDate: moment(),
    autoUpdateInput: true,
    locale: {
        format: "YYYY-MM-DD HH:mm:ss",
    },
});

$('.js__single-date-newb-create').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD' + ' ' + 'HH:mm:ss'));
});


// Event create date
$(".js__single-date-event-edit").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: true,
    minYear: moment(),
    maxYear: parseInt(moment().format("YYYY"), 10),
    startDate: $(this).val(),
    autoUpdateInput: true,
    locale: {
        format: "YYYY-MM-DD HH:mm:ss",
    },
});

$('.js__single-date-event-edit').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD' + ' ' + 'HH:mm:ss'));
});

$(".js__single-date-event-create").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: true,
    minYear: moment(),
    maxYear: parseInt(moment().format("YYYY"), 10),
    startDate: moment(),
    autoUpdateInput: true,
    locale: {
        format: "YYYY-MM-DD HH:mm:ss",
    },
});

$('.js__single-date-event-create').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD' + ' ' + 'HH:mm:ss'));
});


// Image upload

// Laravel file manager
var lfm = function (id, type, options) {
    let button = document.getElementById(id);
    let web_url = $('meta[name="base_url"]').attr('content');

    if (button) {
        button.addEventListener("click", function () {
            var route_prefix =
                options && options.prefix ?
                    options.prefix :
                    "/laravel-filemanager";
            var target_input = document.getElementById("banner-upload");
            var target_preview = document.getElementById("fileupload-preview");

            window.open(
                route_prefix + "?type=" + options.type || "file",
                "FileManager",
                "width=900,height=600"
            );
            window.SetUrl = function (items) {
                var file_path = items
                    .map(function (item) {
                        let itemspl = item.url.split(web_url);
                        if (itemspl[1]) {
                            let newStr = itemspl[1].slice(1);
                            return newStr;
                        }
                        return '';
                    })
                    .join(",");

                // set the value of the desired input to image url
                target_input.value = file_path;

                target_input.dispatchEvent(new Event("change"));
                //clear previous preview
                target_preview.innerHtml = "";
                items.forEach(function (item) {
                    let img = document.createElement("img");
                    img.setAttribute("src", item.thumb_url);
                    img.setAttribute("style", "width: 100%; height: 100%; object-fit: contain; position: absolute; top: 0; left: 0;");
                    // set or change the preview image src
                    let preview_html = img.outerHTML;
                    target_preview.innerHTML = preview_html;

                    target_input.classList.remove("fileupload-new");
                    target_input.classList.add("fileupload-exists");

                    $('input[name="banner"]').val(file_path);
                });

                // trigger change event
                target_preview.dispatchEvent(new Event("change"));
            };
        });
    }
};

var web_url = $('meta[name="base_url"]').attr('content');
var route_prefix = web_url + "/filemanager";
lfm("select-banner", "image", {
    prefix: route_prefix,
    type: 'image'
});

// Image upload