import { fetchData } from '../functions.js';

var lfm = function (className, type, options) {
    let button = document.getElementsByClassName(className);
    let web_url = $('meta[name="base_url"]').attr('content');
    if (button) {
        $("body").on("click", '.' + className, function (e) {
            let table = $(this).attr('table');
            let index = $(this).data('no');
            var route_prefix =
                options && options.prefix ?
                    options.prefix :
                    "/laravel-filemanager";
            var target_input = document.getElementById(table + "-" + index);
            var target_preview = document.getElementById(table + "-fileupload-preview-" + index);
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
                    img.setAttribute("style", "max-height: 150px; max-width: 150px");
                    // set or change the preview image src
                    let preview_html = img.outerHTML;
                    target_preview.innerHTML = preview_html;

                    target_input.classList.remove("fileupload-new");
                    target_input.classList.add("fileupload-exists");

                    $("." + table + "-image-upload-" + index).val(file_path);
                });

                // trigger change event
                target_preview.dispatchEvent(new Event("change"));
            };
        });
    }
};

var web_url = $('meta[name="base_url"]').attr('content');
var route_prefix = web_url + "/filemanager";
lfm("fileupload", "image", {
    prefix: route_prefix,
    type: 'image'
});

$('#add_mobile_icon').on('click', function (e) {
    e.preventDefault();
    fetchData(BASE_URL + '/admin/page-setting/display/render/mobile_icon', 'POST', { _token: $('meta[name="csrf-token"]').attr("content") }).then(data => {
        $('.mobile-icons-list').append(data.form);
    })
});

$('#add_banner').on('click', function (e) {
    e.preventDefault();
    fetchData(BASE_URL + '/admin/page-setting/display/render/banner', 'POST', { _token: $('meta[name="csrf-token"]').attr("content") }).then(data => {
        $('.banner-list').append(data.form);
    })
});