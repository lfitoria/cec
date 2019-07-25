/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import 'jquery-validation';
// any CSS you require will output into a single css file (app.css in this case)
require('../css/forms.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

(function (document, $) {

  CEC.Forms = CEC.Forms || {};

  CEC.Forms.Events = function () {
    var cache = {};
    var _objectPublic = {};

    function bindEvents() {
      cache.nav_items.click(function () {
        cache.form_target[0].value = $(this).data('target');
        if (cache.form.valid()) {
          cache.form.submit();
        }
      });

      cache.form_buttons.click(function () {
        cache.form_target[0].value = $(this).data('target');
        cache.form.submit();
      });

      cache.decision_inputs.change(function () {
        var _this = $(this);
        var targetId = "#" + _this.parent().parent().data("code");
        if ($(this).val() === '1') {
          $(targetId).removeClass("d-none");
        } else if ($(this).val() === '0') {
          $(targetId).addClass("d-none");
          $(targetId).find("input").attr('required', false);
        }
      });
    }

    _objectPublic.init = function () {
      cache.nav_items = $('.form_header_nav_item');
      cache.form_buttons = $('.form_footer_button');
      cache.form_target = $('.form_target_input');
      cache.form = $('.form-request');
      cache.decision_inputs = $(".decision_question input");



      bindEvents();
    };

    return Object.freeze(_objectPublic);
  };

  $(window).on('load', function () {
    var obj = CEC.Forms.Events();
    obj.init();
  });

})(document, $, window.CEC = window.CEC || {});