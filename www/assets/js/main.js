  
    function setupFormValidation(formId) {
      var rules = {};
      var messages = {};
  
      $(formId)
        .find(".validate-field")
        .each(function () {
          var elementClasses = $(this).attr("class").split(" ");
          var fieldName = $(this).attr("name");
  
          elementClasses.forEach(function (cls) {
            switch (cls) {
              case "vname":
                rules[fieldName] = {
                  required: true,
                  minlength: 2,
                  maxlength: 20,
                  lettersonly: true,
                };
                messages[fieldName] = {
                  required: "Este campo es obligatorio.",
                  minlength: "Por favor, ingrese al menos 2 caracteres.",
                  maxlength: "Por favor, ingrese un máximo de 20 caracteres.",
                  lettersonly: "Solo se permiten letras",
                };
                break;
              case "vphone":
                  rules[fieldName] = {
                      required: true,
                      digits: true,
                      minlength: 11,
                      maxlength: 11,
                  };
                  messages[fieldName] = {
                      required: "Por favor, ingrese un número de teléfono.",
                      digits: "Por favor, ingrese solo dígitos.",
                      minlength: "Formato inválido. Faltan digitos. ",
                      maxlength: "Formato inválido. Digitos demas ingresados. ",
                  };
                  break;
              case "vemail":
                rules[fieldName] = {
                  required: true,
                  maxlength: 100,
                  minlength: 11,
                  email: true,
                };
                messages[fieldName] = {
                  required: "Este campo es obligatorio.",
                  minlength: "Ingrese un email válido",
                  maxlength: "Por favor, ingrese un máximo de 100 caracteres.",
                  email: "Ingrese un email válido",
                };
                break;
  
              case "vaddress":
                rules[fieldName] = {
                  required: true,
                  maxlength: 100,
                  minlength: 3,
                };
                messages[fieldName] = {
                  required: "Este campo es obligatorio.",
                  maxlength: "Por favor, ingrese un máximo de 100 caracteres.",
                  minlength: "Por favor, ingrese un minimo de 3 caracteres.",
                };
                break;
              case "vhousenumber":
                rules[fieldName] = {
                  max: 99999999,
                  min: 0,
                };
                messages[fieldName] = {
                  required: "Este campo es obligatorio.",
                  max: "Por favor, ingrese un máximo de 8 digitos.",
                  min: "Por favor, no ingreses números negativos",
                };
                break;
              case "vfloor_dep":
                rules[fieldName] = {
                  maxlength: 8,
                };
                messages[fieldName] = {
                  maxlength: "Por favor, ingrese un máximo de 8 caracteres.",
                };
                break;
              case "vcost":
                rules[fieldName] = {
                  required: true,
                  number: true,
                  min: 0,
                };
                messages[fieldName] = {
                  required: "Este campo es obligatorio.",
                  number: "Por favor, ingrese un número válido.",
                  min: "El costo no puede ser negativo!",
                };
                break;
  
              case "vammount":
                rules[fieldName] = {
                  required: true,
                  number: true,
                  min: 0,
                };
                messages[fieldName] = {
                  required: "Este campo es obligatorio.",
                  number: "Por favor, ingrese un número válido.",
                  min: "La cantidad no puede ser negativa!",
                };
                break;
  
                case "select":
                rules[fieldName] = {
                  required: true,
                };
                messages[fieldName] = {
                  required: "Debe seleccionar una opción.",
                };
                break;
  
              case "vtextarea":
                rules[fieldName] = {
                  required: true,
                  maxlength: 150,
                  minlength: 3,
                };
                messages[fieldName] = {
                  required: "Este campo es obligatorio.",
                  maxlength: "Por favor, ingrese un máximo de 255 caracteres.",
                  minlength: "Por favor, ingrese un minimo de 3 caracteres.",
                };
                break;
                
                case "vavatar":
                rules[fieldName] = {
                  required: true,
                };
                messages[fieldName] = {
                  required: "Este campo es obligatorio.",
                };
                break;
  
                case "vname_product":
                rules[fieldName] = {
                  required: true,
                  minlength: 2,
                  maxlength: 20,
                };
                messages[fieldName] = {
                  required: "Este campo es obligatorio.",
                  minlength: "Por favor, ingrese al menos 2 caracteres.",
                  maxlength: "Por favor, ingrese un máximo de 20 caracteres.",
                };
                break;
  
                case "vcuicuit":
                  rules[fieldName] = {
                      required: true,
                      digits: true,
                      maxlength: 6,
                      minlength: 1,
                  };
                  messages[fieldName] = {
                      required: "Este campo es obligatorio.",
                      digits: "Por favor, ingrese solo dígitos.",
                      maxlength: "Por favor, ingrese un máximo de 6 dígitos.",
                      minlength: "Debe ingresar al menos 1 dígito.",
                  };
                  break;
            }
          });
        });
  
        rules["remito_first_part"] = {
          required: true,
          digits: true, // Solo permite dígitos
          minlength: 4,
          maxlength: 4,
        };
        messages["remito_first_part"] = {
          required: "Este campo es obligatorio.",
          digits: "Ingrese solo dígitos.",
          minlength: "Debe tener exactamente 4 dígitos.",
          maxlength: "Debe tener exactamente 4 dígitos.",
        };
    
        rules["remito_second_part"] = {
          required: true,
          digits: true, // Solo permite dígitos
          minlength: 8,
          maxlength: 8,
        };
        messages["remito_second_part"] = {
          required: "Este campo es obligatorio.",
          digits: "Ingrese solo dígitos.",
          minlength: "Debe tener exactamente 8 dígitos.",
          maxlength: "Debe tener exactamente 8 dígitos.",
        };
  
  
      $(formId).validate({
        rules: rules,
        messages: messages,
      });
    }
  
    
  
    function buysFormSubmit(formId, actionUrl) {
      $(formId).on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
  
        if (!$(formId).valid()) {
          return; // Salir si el formulario no es válido
        }
        $.ajax({
          type: "POST",
          url: actionUrl,
          data: formData,
          dataType: "json",
          success: function (response) {
            var messageContainer = $("#response-message");
            if (response.status === "success") {
              setTimeout(function () {
                toastr.options = {
                  closeButton: true,
                  progressBar: true,
                  showMethod: "slideDown",
                  timeOut: 1500,
                };
                toastr.success(response.message, "ÉXITO");
              });
              //messageContainer.html('<div class="alert alert-success">' + response.message + '</div>');
              resetForm();
  
              setTimeout(function () {
                messageContainer.html("");
              }, 3000);
            } else {
              messageContainer.html(
                '<div class="alert alert-danger">' + response.message + "</div>"
              );
            }
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
            $("#response-message").html(
              '<div class="alert alert-danger">Error en la solicitud AJAX: ' +
                error +
                "<br>" +
                xhr.responseText +
                "</div>"
            );
          },
        });
      });
  
      $(".reload").click(function () {
        location.reload();
      });
  
      function resetForm() {
        $(".reset").val("");
      }
    }
  

setupFormValidation("#change-insertorder-form");
buysFormSubmit(
  "#change-insertorder-form",
  "ordersController.php?token=" + token + "&action=add_order"
);
