/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
import '../../node_modules/bootstrap/js/src/modal.js';

(function (document, $) {

  CEC.App = CEC.App || {};

  CEC.App.Events = {
    showModal: function (title = null, message = null, subMessage = null, type = "feedback_modal_normal") {
      fillModal(title, message, subMessage, type);
      $('#feedback_modal').modal({
        keyboard: false
      });
    }
  };

  function clearModal() {
    
  }
  
  function fillModal(title, message, subMessage, type) {
    $('#feedback_modal .feedback_modal_title').text(title);
    $('#feedback_modal .feedback_modal_message').text(message);
    $('#feedback_modal .feedback_modal_subMessage').text(subMessage);
    $('#feedback_modal').addClass(type);
    
  }

})(document, $, window.CEC = window.CEC || {});


