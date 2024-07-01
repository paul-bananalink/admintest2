// webpack.mix.js
let mix = require("laravel-mix");

//css
mix.copy("resources/css/admin", "public/css/admin");
mix.copy("resources/css/common", "public/css/common");

//js
mix.copy("resources/js/admin", "public/js/admin");
mix.copy("resources/js/common", "public/js/common");

//vendor
mix.copy(
  "vendor/select2/select2/dist/css/select2.min.css",
  "public/css/common/css"
);
mix.copy("vendor/select2/select2/dist/js/select2.min.js", "public/js/common");

mix.copy(
  "node_modules/sweetalert2/dist/sweetalert2.min.js",
  "public/js/common"
);
mix.copy(
  "node_modules/sweetalert2/dist/sweetalert2.min.css",
  "public/css/common/css"
);

mix.copyDirectory("vendor/tinymce/tinymce", "public/js/common/tinymce");

//library
mix.copy("resources/lib", "public/lib");
