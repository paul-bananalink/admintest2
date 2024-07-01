// tinymce editor
tinymce.init({
  license_key: "gpl",
  selector: "textarea#js__editor-noteUser",
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
