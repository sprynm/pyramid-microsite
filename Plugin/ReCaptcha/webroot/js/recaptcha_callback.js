var reCaptchaOnloadCallback = function () {
  var recaptchaNodes = document.querySelectorAll(".g-recaptcha");

  recaptchaNodes.forEach(function (el) {
    var widgetId = grecaptcha.render(el, {
      sitekey: <?php echo json_encode(Configure::read('Settings.ReCaptcha.Google.sitekey')); ?>
      <?php
      // Since invisible captcha overrides submit button action we need to submit the form afterwards.
      if (Configure::read('Settings.ReCaptcha.invisible')):
      ?>
      , callback: function (token) {
        var form = el.closest("form");
        if (!form) return;

        var responseField = form.querySelector(".g-recaptcha-response");
        if (responseField) {
          responseField.value = token;
        }

        form.submit();
      }
      , size: "invisible"
      <?php
      endif;
      ?>
    });

    el.setAttribute("data-grecaptcha-widget-id", String(widgetId));
  });
};
