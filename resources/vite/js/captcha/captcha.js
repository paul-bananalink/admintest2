$(document).ready(function () {
  $('#reload-partner').click(function() {
    $.ajax({
      type: 'GET',
      url: 'login/reload-captcha',
      success: function(data) {
        $("#captcha-img").attr('src', data.captcha_src);
      }
    });
  });
});

$(document).ready(function () {
  $('#reload').click(function() {
    $.ajax({
      type: 'GET',
      url: 'reload-captcha',
      success: function(data) {
        $("#captcha-img").attr('src', data.captcha_src);
      }
    });
  });
});
