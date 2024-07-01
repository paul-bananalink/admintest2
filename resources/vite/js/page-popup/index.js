import createToast from "../toast/script";

let csrfToken = $('meta[name="csrf-token"]').attr("content");

$(".reset").on("click", (e) => {
  let el = $(e.currentTarget);
  let item = el.data("item");

  $.post(
    el.data("action"),
    {
      _token: csrfToken,
    },
    function (data, textStatus, jqXHR) {
      if (data) {
        $(".pop-" + item + " input[type='checkbox']").prop("checked", false);
        $("#createPopup" + item + " input[name='poLink']").val("");
        tinymce.get("js__editor-" + item).setContent("");
        createToast("success", "업데이트 성공.");
      } else {
        createToast("warning", "업데이트 실패.");
      }
    }
  );
});

$(".update").on("click", (e) => {
  e.preventDefault();
  let el = $(e.currentTarget);
  let item = el.data("item");
  let poLink = $("#createPopup" + item + " input[name='poLink']").val();
  let poContent = tinymce.get("js__editor-" + item).getContent();
  let poImage = $("#createPopup" + item + " input[name='poImage']").val();

  $.post(
    el.data("action"),
    {
      _token: csrfToken,
      data: {
        poLink: poLink,
        poContent: poContent,
        poImage: poImage,
      },
    },
    function (data, textStatus, jqXHR) {
      if (data) {
        createToast("success", "업데이트 성공.");
      } else {
        createToast("warning", "업데이트 실패.");
      }
    }
  );
});

tinymce.init({
  license_key: "gpl",
  selector:
    "textarea#js__editor-1, textarea#js__editor-2, textarea#js__editor-3, textarea#js__editor-4, textarea#js__editor-5, textarea#js__editor-6, textarea#js__editor-7, textarea#js__editor-8, textarea#js__editor-9",
  promotion: false,
  branding: false,
  menubar: false,
  skin: "oxide-dark",
  content_css: "dark",
  plugins: "table lists image link code charmap media textcolor",
  toolbar:
    "blocks | bold italic underline strikethrough | alignleft aligncenter alignright justify | charmap code | bullist numlist | indent outdent | forecolor backcolor | link image media | removeformat",

  urlconverter_callback: function (url) {
    if (url.startsWith("/")) {
      return window.location.origin + url;
    } else {
      return url;
    }
  },

  file_picker_callback: function (callback, value, meta) {
    let x =
      window.innerWidth ||
      document.documentElement.clientWidth ||
      document.getElementsByTagName("body")[0].clientWidth;
    let y =
      window.innerHeight ||
      document.documentElement.clientHeight ||
      document.getElementsByTagName("body")[0].clientHeight;

    let type = "image" === meta.filetype ? "Images" : "Files",
      url = "/laravel-filemanager?editor=tinymce7&type=" + type;

    tinymce.activeEditor.windowManager.openUrl({
      url: url,
      title: "File Manager",
      width: x * 0.8,
      height: y * 0.8,
      onMessage: (api, message) => {
        callback(message.content);
      },
    });
  },
});

var lfm = function (className, type, options) {
  let button = document.getElementsByClassName(className);
  let web_url = $('meta[name="base_url"]').attr('content');
  if (button) {
    $("body").on("click", '.' + className, function (e) {
      let index = $(this).data('no');
      var route_prefix =
        options && options.prefix ?
          options.prefix :
          "/laravel-filemanager";
      var target_input = document.getElementById("image-" + index);
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
          img.setAttribute("style", "max-width: 100%; max-height: 100%;");
          // set or change the preview image src
          let preview_html = img.outerHTML;
          target_preview.innerHTML = preview_html;

          target_input.classList.remove("fileupload-new");
          target_input.classList.add("fileupload-exists");

          $("." + "image-upload-" + index).val(file_path);
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

$(".cancel-btn").click(function (e) {
  e.preventDefault();
  Swal.fire({
    title: "Are you sure?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      var el = $(this);

      $.post(
        el.data("action"),
        {
          _token: csrfToken,
        },
        function (data, textStatus, jqXHR) {
          if (data) {
            el.closest('.col-md-4').remove();
            createToast("success", "업데이트 성공.");
          } else {
            createToast("warning", "업데이트 실패.");
          }
        }
      );
    }
  })
});