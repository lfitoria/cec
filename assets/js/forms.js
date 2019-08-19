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

    function addTagForm($collectionHolder, $newLinkLi) {
      // Get the data-prototype explained earlier
      var prototype = $collectionHolder.data('prototype');

      // get the new index
      var index = $collectionHolder.data('index');

      var newForm = prototype;
      // You need this only if you didn't set 'label' => false in your tags field in TaskType
      // Replace '__name__label__' in the prototype's HTML to
      // instead be a number based on how many items we have
      // newForm = newForm.replace(/__name__label__/g, index);

      // Replace '__name__' in the prototype's HTML to
      // instead be a number based on how many items we have
      newForm = newForm.replace(/__name__/g, index);

      // increase the index with one for the next item
      $collectionHolder.data('index', index + 1);
      // Display the form in the page in an li, before the "Add a tag" link li
      var inputGroup = $('<div class="input-group input-group-cont"></div>').append(newForm);
      var $newFormLi = $('<li></li>').append(inputGroup);


      $newFormLi.find(".input-group-cont").append('<div class="input-group-append"><a class="selected_files_list_item--delete" href="#">Eliminar</a></div>');
      $newLinkLi.before($newFormLi);

    }
    function showActivatedInputs() {
      cache.decision_inputs.each(function () {
        var _this = $(this);
        var targetId = "#" + _this.parent().parent().data("code");
        if ($(this).is(":checked") && $(this).val() === '1') {
          $(targetId).removeClass("d-none");
        } else {
          $(targetId).addClass("d-none");
          $(targetId).find("input").attr('required', false);
        }
      });
    }

    function applyNumbering() {
      var number = 1;
      cache.question_labels.each(function () {
        var _this = $(this);
        _this.text(cache.form.data("number") + "." + number + " " + _this.text());
        number++;
      });
    }

    function bindEvents() {
      cache.nav_items.click(function () {
        cache.form_target[0].value = $(this).data('target');
        if (cache.form.valid()) {
          cache.form.submit();
        }
      });

      cache.form_buttons.click(function () {
        cache.form_target[0].value = $(this).data('target');
        if (cache.form.valid()) {
          cache.form.submit();
        }
      });

      cache.decision_inputs.change(function () {
        var _this = $(this);
        var targetId = "#" + _this.parent().parent().data("code");
        if ($(this).is(":checked") && $(this).val() === '1') {
          $(targetId).removeClass("d-none");
        } else{
          $(targetId).addClass("d-none");
          $(targetId).find("input").attr('required', false);
        }
      });

      cache.uploaded_item_delete.click(function (e) {
        e.preventDefault();
        var _this = $(this);
        var path = "/CEC/public/file/removeFile";
        $.ajax({
          type: 'POST',
          url: path,
          context: _this,
          data: {
            id: _this[0].dataset.id
          },
          dataType: 'json',
          success: function (file) {
            if (file.wasDeleted) {
              _this.parent().remove();
            }
          }
        });
      });

      cache.selected_item_delete.click(function (e) {
        e.preventDefault();
        var _this = $(this);
        removeSelectedFile(_this);
      });

      cache.fileInputs.on('change', function (event) {
        showlabel(event);
      });

      cache.addFileButton.on('click', function (e) {
        var _this = $(this);
        var target = _this.data("list");
        var collectionHolder = $('[data-list-target="'+target+'"]');
        var newLinkLi = $('[data-new-item="'+target+'"]');
        cache.fileInputs.off('change');
        cache.selected_item_delete.off('click');
        addTagForm(collectionHolder, newLinkLi);
        cache.fileInputs = $('.custom-file-input');
        cache.fileInputs.on('change', function (event) {
          showlabel(event);
        });

        cache.selected_item_delete = $(".selected_files_list_item--delete");
        cache.selected_item_delete.on('click', function (e) {
          e.preventDefault();
          var _this = $(this);
          removeSelectedFile(_this);
        });
      });
    }

    function showlabel(event) {
      var inputFile = event.currentTarget;
      $(inputFile).parent()
              .find('.custom-file-label')
              .html(inputFile.files[0].name);
    }

    function removeSelectedFile(_this) {
      _this.parent().parent().parent().remove();
    }

    _objectPublic.init = function () {
      cache.nav_items = $('.form_header_nav_item');
      cache.form_buttons = $('.form_footer_button');
      cache.form_target = $('.form_target_input');
      cache.form = $('.form-request');
      cache.decision_inputs = $(".decision_question input");
      cache.uploaded_item_delete = $(".uploaded_files_list_item--delete");
      cache.selected_item_delete = $(".selected_files_list_item--delete");
      cache.question_labels = $("form .form-group legend.col-form-label, \n\
                                form .form-group label:not(.error):not(.custom-control-label):not(.custom-file-label):not(.no-label)");
      cache.fileInputs = $('.custom-file-input');
      cache.addFileButton = $(".add_file_button");

      var collectionFileHolder = $('.collecion_list');
      for (var i = 0; i < collectionFileHolder.length; i++) {
        collectionFileHolder[i].dataset.index = collectionFileHolder[i].querySelectorAll('input').length;
      }

      showActivatedInputs();
      applyNumbering();
      bindEvents();
    };

    return Object.freeze(_objectPublic);
  };

  $(window).on('load', function () {
    var obj = CEC.Forms.Events();
    obj.init();
  });

})(document, $, window.CEC = window.CEC || {});