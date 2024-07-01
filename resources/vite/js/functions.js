export function openWindow(route) {
  var width = 1000;
  var height = 750;
  var left = (screen.width - width) / 2;
  var top = (screen.height - height) / 2;

  window.open(
    route + "?hideNavbar=1",
    "NewWindow",
    "width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
  );
}

export function fetchData(url, method = "GET", body = null, headers = {}) {
  const accessToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
  let fetchOptions = {
    method: method,
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      Authorization: "Bearer " + accessToken,
      ...headers,
    },
  };

  if (body) {
    fetchOptions.body = JSON.stringify(body);
  }

  return new Promise((resolve, reject) => {
    fetch(url, fetchOptions)
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        resolve(data);
      })
      .catch((error) => {
        reject(error);
      });
  });
}

export function parseNumberToDecimal(number) {
  number = parseInt(number);
  return number.toLocaleString("en-US");
}

export function setNumberPhone(number) {
  var cleaned = ("" + number).replace(/\D/g, "");

  if (cleaned.length === 11) {
    return (
      cleaned.substring(0, 3) +
      " " +
      cleaned.substring(3, 7) +
      " " +
      cleaned.substring(7, 11)
    );
  } else if (cleaned.length === 10) {
    return (
      cleaned.substring(0, 3) +
      " " +
      cleaned.substring(3, 6) +
      " " +
      cleaned.substring(6, 10)
    );
  } else {
    return number;
  }
}

export function formDataToObject(form) {
  var formDataObject = {};
  var formDataArray = {};

  if (typeof form === "string") {
    formDataArray = $("#" + form).serializeArray();
  } else if (Array.isArray(form)) {
    formDataArray = form;
  } else {
    return formDataObject;
  }
  $.each(formDataArray, function (index, field) {
    formDataObject[field.name] = field.value;
  });
  return formDataObject;
}

export const actionInputFormatMoney = (el) => {
  $(el).on("input", function (e) {
    let value = $(e.currentTarget).val().replace(/\D/g, "");

    if (value.length > 4 && value.charAt(0) === "0") {
      value = value.substr(1);
    }

    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    let number = value.toLocaleString("en-US");
    $(e.currentTarget).val(number);
    $(e.currentTarget).val(value);
  });
};

export const actionInputFormatPercent = (el) => {
  $(el).on("input", function (e) {
    let value = $(e.currentTarget)
      .val()
      .replace(/[^\d.]/g, "");

    let hasDecimalPoint = value.indexOf(".") !== -1;

    let numericValue = parseFloat(value);
    if (isNaN(numericValue)) {
      const currentValue = $(e.currentTarget).val();
      $(e.currentTarget).val(currentValue.slice(0, -1));
    } else {
      if (hasDecimalPoint) {
        let parts = value.split(".");
        value = parts.shift() + "." + parts.join("");
      }
      $(e.currentTarget).val(value);
    }
  });
};

export function actionPhoneNumberInput(el) {
  $(el).on("input", function (e) {
    let value = $(this).val();

    value = value.replace(/[^0-9]/g, "");

    if (
      value.startsWith("010") ||
      value.startsWith("011") ||
      value.startsWith("016") ||
      value.startsWith("017") ||
      value.startsWith("018") ||
      value.startsWith("019")
    ) {
      if (value.length > 10) {
        value =
          value.slice(0, 3) +
          " " +
          value.slice(3, 7) +
          " " +
          value.slice(7, 11);
      } else if (value.length > 7) {
        value =
          value.slice(0, 3) + " " + value.slice(3, 7) + " " + value.slice(7);
      } else if (value.length > 3) {
        value = value.slice(0, 3) + " " + value.slice(3);
      }
    } else {
      if (value.length > 7) {
        value =
          value.slice(0, 3) + " " + value.slice(3, 7) + " " + value.slice(7);
      } else if (value.length > 3) {
        value = value.slice(0, 3) + " " + value.slice(3);
      }
    }
    $(this).val(value);
  });
}

export function initTinymce() {
  tinymce.init({
    license_key: "gpl",
    selector: "textarea#js__editor, .js__editor",
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
}

export function handleUploadImage() {
  // Laravel file manager
  var lfm = function (className, type, options) {
    let button = document.getElementsByClassName(className);
    let web_url = $('meta[name="base_url"]').attr("content");

    if (button) {
      $("body").on("click", "." + className, function (e) {
        let index = $(this).data("index");

        var route_prefix =
          options && options.prefix ? options.prefix : "/laravel-filemanager";
        var target_input = document.getElementById("image-upload-" + index);
        var target_preview = document.getElementById(
          "fileupload-preview-" + index
        );

        window.open(
          route_prefix + "?type=" + options.type || "file",
          "FileManager",
          "width=1100,height=700"
        );
        window.SetUrl = function (items) {
          var file_path = items
            .map(function (item) {
              let itemspl = item.url.split(web_url);
              if (itemspl[1]) {
                let newStr = itemspl[1].slice(1);
                return newStr;
              }
              return "";
            })
            .join(",");
          // set the value of the desired input to image url
          target_input.value = file_path;
          target_input.dispatchEvent(new Event("change"));
          //clear previous preview
          target_preview.innerHtml = "";

          console.log(items);
          items.forEach(function (item) {
            let img = document.createElement("img");
            img.setAttribute("src", item.thumb_url);
            // set or change the preview image src
            let preview_html = img.outerHTML;
            target_preview.innerHTML = preview_html;

            target_input.classList.remove("fileupload-new");
            target_input.classList.add("fileupload-exists");

            $(".image_upload_" + index).val(file_path);
          });

          // trigger change event
          target_preview.dispatchEvent(new Event("change"));
        };
      });
    }
  };

  var web_url = $('meta[name="base_url"]').attr("content");
  var route_prefix = web_url + "/filemanager";
  lfm("upload_image", "image", {
    prefix: route_prefix,
    type: "image",
  });

  $(".remove-image, .delete_image").on("click", function (e) {
    let id = $(e.currentTarget).data("id");
    let input = $(`.image_upload_${id}`);
    let image = $(`#fileupload-preview-${id} img`);
    input.val("");
    image.remove();
  });
}
