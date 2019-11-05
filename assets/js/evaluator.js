/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you require will output into a single css file (app.css in this case)
require('../css/evaluator.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

(function (document, $) {

  CEC.Evaluator = CEC.Evaluator || {};

  CEC.Evaluator.Events = function () {
    var cache = {};
    var _objectPublic = {};

    function bindEvents() {
      cache.btn_complete_assigment.click(function (e) {
        e.preventDefault();
        var _this = $(this);
        var path = _this[0].dataset.path;
        var project_id = _this[0].dataset.request;
        var evaluators = []; 
        $(".evaluator_list_assigment.show input[name=evaluators]:checked").each(function () {
          evaluators.push($(this).val());
        });
        $.ajax({
          type: 'POST',
          url: path,
          context: _this,
          data: {
            evaluators: evaluators,
            project_id: project_id
          },
          dataType: 'json',
          success: function (file) {
            if (file.wasDeleted) {
              _this.parent().remove();
              
            }

            if (file.wasAssigned){
              Swal.fire({
                position: 'center',
                type: 'success',
                title: `${file.countEvals} evaluador(es) asignado(s)`,
                showConfirmButton: false,
                timer: 2200
              })
              location.reload();
            }else{
              Swal.fire({
                position: 'center',
                type: 'error',
                title: 'Evaluador(es) desasignado(s)',
                showConfirmButton: false,
                timer: 2200
              })
              location.reload();
            }
            console.log(file.countEvals);
          }
        });
      });
    }


    _objectPublic.init = function () {
      cache.btn_complete_assigment = $('.evaluator_list_assigment .evaluator_list_assigment--btn-complete');

      bindEvents();
    };

    return Object.freeze(_objectPublic);
  };

  $(window).on('load', function () {
    var obj = CEC.Evaluator.Events();
    obj.init();
  });

})(document, $, window.CEC = window.CEC || {});
