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
    var mimeTypes = [
      'application/pdf',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      'application/vnd.openxmlformats-officedocument.presentationml.presentation',
      'application/msword',
      'application/vnd.ms-powerpoint',
      'application/vnd.oasis.opendocument.text',
      'image/png',
      'image/jpeg',
      'application/zip',
      'application/x-rar',
    ];
    var _objectPublic = {};

    function addTagForm($collectionHolder, $newLinkLi, target) {
      // Get the data-prototype explained earlier
      var prototype = $collectionHolder.data('prototype');

      // get the new index
      var index = $collectionHolder.data('index');

      console.log(target);

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
      var $newFormLi = $('<li class="input-group-list"></li>').append(inputGroup);


      $newFormLi.find(".input-group-cont").append('<div class="input-group-append"><a class="selected_files_list_item--delete" href="#">Eliminar</a></div>');
      if(target == "aditionalFiles"){
        $newFormLi.append(`<input type="text" class="input-filesDes small" placeholder="Nombre o breve descripción del documento (opcional)" name="${target}_fileDescription[${index}]">`);
      }
      $newLinkLi.before($newFormLi);

    }
    function showActivatedInputs() {
      
      cache.decision_inputs.each(function () {
        var _this = $(this);
        var targetId = "#" + _this.parent().parent().data("code");
        if ($(this).is(":checked") && $(this).val() === '1') {
          $(targetId).removeClass("d-none");
          $(".add_file_button").click();
          

        } else {
          $(targetId).addClass("d-none");
          $(targetId).find("input").attr('required', false);
        }
      });
    }
    function showCatInputs() {
      cache.decision_inputs.each(function () {
        console.log($(this).val());
        var _this = $(this);
        var targetId = "#categoryBiomedicaFiles";
        if ($(this).is(":checked") && $(this).val() === '43') {
          $(targetId).removeClass("d-none");
        }
        if ($(this).is(":checked") && $(this).val() === '44') {
          $(targetId).removeClass("d-none");
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
        if (cache.form.valid() && validFilesSize(cache.fileInputs)) {
          cache.form.submit();
        }
      });
      
      cache.form_buttons.click(function () {
        cache.form_target[0].value = $(this).data('target');
        if (cache.form_finish[0]) {
          cache.form_finish[0].value = $(this).data('finish');
        }
        if (cache.form.valid() && validFilesSize(cache.fileInputs)) {
          if (cache.form_finish[0] !== undefined && cache.form_finish[0].value == 1) {

            jQuery('#valdiate_send_user').modal('show');

            $('#valdiate_send_user_submit').click(function (event) {
              cache.form.submit()
              event.preventDefault();
              var myform = document.getElementById("valdiate_send_user_form");
              var action = document.getElementById("valdiate_send_user_form").action;
              var fd = new FormData(myform);
              var _this = $(this);
              //var path = "/cec/public/validate_user_send";
              console.log("valdiate_send_user_submit");
              var path = "/validate_user_send";
              $.ajax({
                type: 'POST',
                enctype: "multipart/form-data",
                url: path,
                context: _this,
                data: fd,
                processData: false,
                contentType: false,
                beforeSend: loadStart,
                complete: loadStop,
                dataType: 'json'
              }).done(function (data) {
                console.log(data.wasAssigned);
                //console.log(cache.form.submit());
                if (data.wasAssigned === false) {

                  jQuery("#errorUserReq").removeClass("d-none");
                } else {
                  jQuery("#errorUserReq").addClass("d-none");
                  $("#valdiate_send_user_form").hide();
                  cache.form.submit();

                  Swal.fire({
                    position: 'center',
                    type: 'info',
                    title: 'Guardando información',
                    showConfirmButton: false,
                    //timer: 1500
                  });
                }


              });
              // finajax
            });
          } else {

            cache.form.submit();

            Swal.fire({
              position: 'center',
              type: 'info',
              title: 'Guardando información',
              showConfirmButton: false,
              //timer: 1500
            });
          }
        }
      });
      cache.btn_new_user_modal.click(function (event) {
        event.preventDefault();
        console.log("entrenew");
        var myform = document.getElementById("ldap_user_new_modal_form");
              var action = document.getElementById("ldap_user_new_modal_form").action;
              var fd = new FormData(myform);
              var _this = $(this);
              // var path = "/cec/public/validate_user_send";
              var path = "/ldap/user/new-modal";
              console.log(action);
              console.log(path);
              if (cache.form.valid()) {
              $.ajax({
                type: 'POST',
                enctype: "multipart/form-data",
                url: action,
                context: _this,
                data: fd,
                processData: false,
                contentType: false,
                // beforeSend: loadStart,
                // complete: loadStop,
                
                dataType: 'json'
              }).done(function (data) {
                console.log('respuesta:'+ data.wasAssigned);
                console.log('respuesta:'+ data.error);
                
                
                if (data.wasAssigned === false) {

                  Swal.fire({
                    position: 'center',
                    type: 'error',
                    title: 'Error. Correo ya existe.',
                    showConfirmButton: false,
                    timer: 1500
                  });
                } else {

                  Swal.fire({
                    position: 'center',
                    type: 'info',
                    title: 'Usuario creado',
                    showConfirmButton: false,
                    timer: 1500
                  });
                  jQuery('#new_user_modal_open').modal('hide');
                  location.reload();
                }
              });
              // finajax
            }
      });

      function loadStart() {
        $(".loadbox").removeClass("d-none");
        $("#valdiate_send_user_form").hide();
      }
      function loadStop() {
        $(".loadbox").addClass("d-none");
        $("#valdiate_send_user_form").show();
      }

      function validFilesSize(inputs) {
        $("#size-files-error").addClass("d-none");
        $("#extension-files-error").addClass("d-none");

        var totalSize = 0;
        var hasValidExtension = true;
        inputs.each(function () {
          if(this.files[0]){
              totalSize += this.files[0].size;
            if (mimeTypes.indexOf(this.files[0].type) < 0) {
              hasValidExtension = false;
              this.classList.add("invalid-extension");
            }
          }
        });
        totalSize = totalSize / 1000000;
        if (totalSize > 40 || !hasValidExtension) {
          if (totalSize > 40) {
            $("#size-files-error").removeClass("d-none");
          }
          if (!hasValidExtension) {
            $("#extension-files-error").removeClass("d-none");
          }
          return false;
        }
        return true;
      }

      cache.decision_inputs.change(function () {
        
        var _this = $(this);
        var targetId = "#" + _this.parent().parent().data("code");
        if ($(this).is(":checked") && $(this).val() === '1') {
          $(targetId).removeClass("d-none");
          $(targetId).find("input").attr('required', true);
        } else {
          $(targetId).addClass("d-none");
          $(targetId).find("input").attr('required', false);
          
        }
      });
      cache.d_disable_question.change(function () {
        console.log("d_disable_question")
        // var _this = $(this);
        //$(this).parent().parent().parent().find('textarea').attr('disabled',true);
        // var targetId = "#" + _this.parent().parent().data("code");
        if ($(this).is(":checked")) {
          $(this).parent().parent().parent().find('textarea').attr('disabled',true);
        } else {
          $(this).parent().parent().parent().find('textarea').attr('disabled',false);
        }
      });

      cache.project_request_category.change(function () {
        var _this = $(this);
        var targetId = "#categoryBiomedicaFiles";
        if ($(this).is(":checked") && $(this).val() === '43' || $(this).is(":checked") && $(this).val() === '44') {
          $(targetId).removeClass("d-none");

        }
      });

      cache.uploaded_item_delete.click(function (e) {
        e.preventDefault();
        var _this = $(this);
        var path = "/file/removeFile";
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
              _this.parent().parent().remove();
            }
          }
        });
      });

      cache.uploaded_student_delete.click(function (e) {
        e.preventDefault();
        var _this = $(this);
        var path = _this[0].dataset.path;
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
              _this.parent().parent().remove();
            }
          }
        });
      });

      cache.selected_item_delete.click(function (e) {
        e.preventDefault();
        var _this = $(this);
        removeSelectedFile(_this);
      });

      cache.selected_item_delete.click(function (e) {
        e.preventDefault();
        var _this = $(this);
        removeSelectedTeamWork(_this);
      });

      cache.letter_counter_inputs.on("change keyup paste", function (e) {
        var _this = $(this);
        if ((_this.data("max") - _this.val().length) >= 0) {
          return setLetterCounter(_this);
        }

      });

      cache.fileInputs.on('change', function (event) {
        showlabel(event);

      });

      cache.addFileButton.on('click', function (e) {
        var _this = $(this);
        var target = _this.data("list");
        var collectionHolder = $('[data-list-target="' + target + '"]');
        var newLinkLi = $('[data-new-item="' + target + '"]');
        cache.fileInputs.off('change');
        cache.selected_item_delete.off('click');
        addTagForm(collectionHolder, newLinkLi, target);
        cache.fileInputs = $('.custom-file-input');
        cache.fileInputs.on('change', function (event) {
          showlabel(event);
          if (mimeTypes.indexOf(event.currentTarget.files[0].type) < 0) {
            this.classList.add("invalid-extension");
          } else {
            this.classList.remove("invalid-extension");
          }
        });

        cache.selected_item_delete = $(".selected_files_list_item--delete");
        cache.selected_item_delete.on('click', function (e) {
          e.preventDefault();
          var _this = $(this);
          removeSelectedFile(_this);
        });
      });

      cache.addStudentButton.click(function (e) {
        e.preventDefault();
        var _this = $(this);
        var path = _this[0].dataset.path;
        $.ajax({
          type: 'POST',
          url: path,
          context: _this,
          data: {
            id: $(".add_student_input").val()
          },
          // dataType: 'json',
          success: function (response) {
            if (response.studentWasFound) {
              const studentCount = $(".student_row").length;
              const studentRow =
                      `<tr class="student_row">
                <td scope="col"><input type="text" readonly class="form-control-plaintext" name="teamWork[student_name][${studentCount}]" value="${response.student.NOMBRE} ${response.student.APELLIDO1} ${response.student['APELLIDO2']}"></td>
                <td scope="col"><input type="text" readonly class="form-control-plaintext" name="teamWork[student_id][${studentCount}]" value="${response.student['IDENTIFICACION']}"></td>
                <td scope="col"><input type="text" readonly class="form-control-plaintext" name="teamWork[student_email][${studentCount}]" value="${response.student['E.DIRECCION_ELECTRONICA_INST']}"></td>
                <td scope="col"><a class="selected_teamwork_item--delete" href="#">Eliminar</a></td>
              </tr>`;

              $(".team_work_table").append(studentRow);
              cache.selected_student_delete.off("click");
              cache.selected_student_delete = $(".selected_teamwork_item--delete");
              cache.selected_student_delete.on('click', function (e) {
                e.preventDefault();
                var _this = $(this);
                removeSelectedTeamWork(_this);
              });
              Swal.fire({
                position: 'center',
                type: 'success',
                title: 'Estudiante agregado',
                showConfirmButton: false,
                timer: 1500
              });
            } else {
              Swal.fire({
                position: 'center',
                type: 'error',
                title: 'Estudiante no encontrado',
                showConfirmButton: false,
                timer: 1500
              });
            }
          }
        });
      });

      cache.addProjectInfoButton.click(function (e) {
        e.preventDefault();
        var _this = $(this);
        var path = _this[0].dataset.path;
        $.ajax({
          type: 'POST',
          url: path,
          context: _this,
          data: {
            projectCode: $(".add_project_info_input").val()
          },
          // dataType: 'json',
          success: function (response) {
            if (response.projectWasFound) {

              $("#project_request_title").val(response.projectData.dsc_proyecto);
              $("#project_request_projectUnit").val(response.projectData.dsc_unidad);
              console.log(response.projectData);
              $("#project_request_uacademica").val(response.projectData.id_unidad);

              $(".project_researchers_table").html("");
              $(".project_principal_researchers_row").remove("");
              $("#project_principal_researchers .no-data").remove("");

              var researchers = response.researchers.filter(function (el) {
                return el.ID_TIPO_PARTICIPACION === "43";
              });

              var principalResearchers = response.researchers.filter(function (el) {
                return el.ID_TIPO_PARTICIPACION === "42";
              });
              if (researchers.length > 0) {
                for (var i = 0; i < researchers.length; i++) {
                  var researcherRow = `<tr>
              <td scope="col">${researchers[i].NOMBRE.trim()} ${researchers[i].APELLIDO1.trim()} ${researchers[i].APELLIDO2.trim()}</td>
              <td scope="col">${researchers[i].ID_PARTICIPANTE}</td>
              <td scope="col">${researchers[i].ID_PARTICIPANTE}</td>
            </tr>`;

                  $(".project_researchers_table").append(researcherRow);
                }
              } else {
                console.log("no researchers.length");
                var researcherRowNO = `<tr>
                  <td scope="col" colspan="3">Sin datos</td>
                </tr>`;
                $(".project_researchers_table").append(researcherRowNO);
              }

              for (var i = 0; i < principalResearchers.length; i++) {
                var researcherRow = `<input type="text" readonly class="form-control mb-2 project_principal_researchers_row" name="" value="${principalResearchers[i].NOMBRE} ${principalResearchers[i].APELLIDO1} ${principalResearchers[i].APELLIDO2}">`;
                $("#project_principal_researchers").append(researcherRow);
              }



              Swal.fire({
                position: 'center',
                type: 'success',
                title: 'Proyecto agregado',
                showConfirmButton: false,
                timer: 1500
              })
            } else {
              Swal.fire({
                position: 'center',
                type: 'error',
                title: 'Proyecto no encontrado',
                showConfirmButton: false,
                timer: 1500
              })
            }
          }
        });
      });
      //new
      cache.getObtenerNumeroDeEmpleado.click(function (e) {
        e.preventDefault();
        // var _this = $(this);
        // let num = $(".add_getObtenerNumeroDeEmpleado_input").val();
        let num = "205770949";
        let u = "SysUsrVicerrectoriaInvestigacion";
        let p = "FN5uMcTVBDqv0";

        console.log("entranum");
        console.log(num);
        //var path = _this[0].dataset.path;
        $.ajax({
          type: 'POST',
          url: 'https://172.16.96.10/Ws_DatosPersonales.svc/rest/ObtenerNumeroDeEmpleado',
          // context: _this,
          data: {
            pvc_Usuario: u ,
            pvc_Clave: p,
            pvn_IdTipoIdentificacion: 1,
            pvc_IdPersonal: "205770949",
          },
          dataType: 'json',
          success: function (response) {
            console.log("respuesta ajax"+response)
          },
          error: function (xhr, textStatus, error) { 
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
          }
        });
        
      });
    }



    function showlabel(event) {
      var inputFile = event.currentTarget;
      $(inputFile).parent()
              .find('.custom-file-label')
              .html(inputFile.files[0].name);
    }

    function setLetterCounter(_this) {
      _this.parent().find(".count").text(_this.data("max") - _this.val().length);
      return true;
    }

    function removeSelectedFile(_this) {
      _this.parent().parent().parent().remove();
    }

    function removeSelectedTeamWork(_this) {
      _this.parent().parent().remove();
    }

    _objectPublic.init = function () {
      cache.nav_items = $('.form_header_nav_item');
      cache.letter_counter_inputs = $('.letter-counter');
      cache.form_buttons = $('.form_footer_button');
      cache.btn_new_user_modal = $('#btn_new_user_modal');
      cache.form_target = $('.form_target_input');
      cache.form_finish = $('.form_finish_input');
      cache.form = $('.form-request, .form-eval, #ldap_user_new_modal_form');
      cache.decision_inputs = $(".decision_question input");
      cache.d_disable_question = $("input.d_disable_question");
      cache.project_request_category = $("#project_request_category input");
      cache.uploaded_item_delete = $(".uploaded_files_list_item--delete");
      cache.selected_item_delete = $(".selected_files_list_item--delete");
      cache.question_labels = $("form .form-group legend.col-form-label:not(.no-label), \n\
                                form .form-group label:not(.error):not(.custom-control-label):not(.custom-file-label):not(.no-label)");
      cache.fileInputs = $('.custom-file-input');
      cache.addFileButton = $(".add_file_button");
      cache.addStudentButton = $(".add_student_button");
      cache.selected_student_delete = $(".selected_teamwork_item--delete");
      cache.uploaded_student_delete = $(".uploaded_teamwork_item--delete");
      cache.addProjectInfoButton = $(".add_project_info_button");
      cache.getObtenerNumeroDeEmpleado = $(".getObtenerNumeroDeEmpleado");

      var collectionFileHolder = $('.collecion_list');
      for (var i = 0; i < collectionFileHolder.length; i++) {
        collectionFileHolder[i].dataset.index = collectionFileHolder[i].querySelectorAll('input').length;
      }

      showActivatedInputs();
      showCatInputs();
      applyNumbering();
      bindEvents();
      
      cache.letter_counter_inputs.each(function (e) {
        var _this = $(this);
        if ((_this.data("max") - _this.val().length) >= 0) {
          setLetterCounter(_this);
        }

      });
      
    };

    return Object.freeze(_objectPublic);
  };

  $(window).on('load', function () {
    var obj = CEC.Forms.Events();
    obj.init();
  });

})(document, $, window.CEC = window.CEC || {});
