import createToast from '../toast/script'

// Laravel file manager
var lfm = function (className, type, options) {
    let button = document.getElementsByClassName(className);
    let web_url = $('meta[name="base_url"]').attr('content');

    if (button) {
          $("body").on("click", '.'+className, function (e) {
            let index = $(this).data('no');

            var route_prefix =
                options && options.prefix ?
                    options.prefix :
                    "/laravel-filemanager";
            var target_input = document.getElementById("banner-upload-" + index);
            var target_preview = document.getElementById("fileupload-preview-" + index);

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
                    img.setAttribute("style", "max-height: 150px;");
                    // set or change the preview image src
                    let preview_html = img.outerHTML;
                    target_preview.innerHTML = preview_html;

                    target_input.classList.remove("fileupload-new");
                    target_input.classList.add("fileupload-exists");

                    $(".image_upload_"+index).val(file_path);
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

$(function() {
    $('#sortable').sortable();
});

var addBanner = function (data_action) {
    $.ajax({
        url: data_action,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(html) {
            $('#sortable').append(html);
        },
        error: function (errors) {
            console.log(errors);
        },
    });
}

$('#add-banner-btn').on('click', function () {
    let len = $('#sortable>div').length;
    if (len >= 5) {
        createToast('warning', '최대 5개');
        return;
    }

    let data_action = $(this).data('action');
    addBanner(data_action);
});

$('body').on('click', '.remove-banner-btn', function () {
    let no = $(this).data('no');
    $('#banner-' + no).remove();
});
