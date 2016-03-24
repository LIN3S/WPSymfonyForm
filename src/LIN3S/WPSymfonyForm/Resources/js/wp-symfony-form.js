/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Beñat Espiña <benatespina@gmail.com>
 */

var WPSymfonyForm = (function () {
  var
    sendingCallbacks = [],
    successCallbacks = [],
    errorCallbacks = [];

  return {
    formSelector: '.form',
    formErrorsSelector: '.form__errors',
    onSending: function (callback) {
      sendingCallbacks.push(callback);
    },

    onSuccess: function (callback) {
      successCallbacks.push(callback);
    },

    onError: function (callback) {
      errorCallbacks.push(callback);
    },

    triggerSendingCallbacks: function ($form) {
      sendingCallbacks.forEach(function (callback) {
        callback($form);
      });
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
}());

(function ($) {

  $(WPSymfonyForm.formSelector).submit(function (event) {
    var $form = $(event.currentTarget);

    event.preventDefault();

    WPSymfonyForm.triggerSendingCallbacks($form);

    $.ajax({
      type: 'POST',
      url: WPSymfonyFormSettings.ajaxUrl,
      data: $form.serialize() + '&action=form_submit',
      dataType: 'json',
      success: function () {
        $form.find(WPSymfonyForm.formErrorsSelector).text('');
        WPSymfonyForm.triggerSuccessCallbacks($form);
        $form.get(0).reset();
      },
      error: function (data) {
        var json = JSON.parse(data.responseText);

        $form.find(WPSymfonyForm.formErrorsSelector).text('');
        for (var key in json) {
          $form.find('[name*="[' + key + ']"]')
            .siblings(WPSymfonyForm.formErrorsSelector).text(json[key]);
        }
        WPSymfonyForm.triggerErrorCallbacks($form);
      }
    });
  })

}(jQuery));
