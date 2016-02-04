var WPSymfonyForm = (function () {
  var successCallbacks = [],
    errorCallbacks = [];

  return {
    formSelector: '.form',
    formErrorsSelector: '.form__errors',
    onSuccess: function (callback) {
      successCallbacks.push(callback);
    },

    onError: function (callback) {
      errorCallbacks.push(callback);
    },

    triggerSuccessCallbacks: function ($form) {
      successCallbacks.forEach(function (callback) {
        callback($form);
      });
    },

    triggerErrorCallbacks: function ($form) {
      errorCallbacks.forEach(function (callback) {
        callback($form);
      });
    }
  }
})();

(function ($) {
  $(WPSymfonyForm.formSelector).submit(function (ev) {
    ev.preventDefault();
    var $form = $(ev.currentTarget);
    $form.find('[type="submit"]').hide();
    $.ajax({
      type: "POST",
      url: WPSymfonyFormSettings.ajaxUrl,
      data: $form.serialize() + '&action=form_submit',
      dataType: "json",
      success: function () {
        $form.find(WPSymfonyForm.formErrorsSelector).text('');
        WPSymfonyForm.triggerSuccessCallbacks($form);
      },
      error: function (data) {
        $form.find('[type="submit"]').show();
        $form.find(WPSymfonyForm.formErrorsSelector).text('');

        var json = JSON.parse(data.responseText);
        for (var key in json) {
          $form.find('[name*="[' + key + ']"]')
            .siblings(WPSymfonyForm.formErrorsSelector).text(json[key]);
        }
        WPSymfonyForm.triggerErrorCallbacks($form);
      }
    });
  })
})(jQuery);
