$(document).ready(function () {
  $("#dates-player-form").validate({
    rules: {
      name_player: {
        required: true,
        minlength: 3,
        maxlength: 20,
        lettersonly: true,
      },
      lastname_player: {
        required: true,
        minlength: 3,
        maxlength: 20,
        lettersonly: true,
      },
      username: {
        required: true,
        minlength: 4,
        maxlength: 20,
        alphanumeric: true,
      },
      email: {
        required: true,
        email: true,
      },
    },
    messages: {
      name_player: {
        required: "Por favor, ingresa tu nombre.",
        minlength: "El nombre debe tener al menos 3 caracteres.",
        maxlength: "El nombre no puede superar los 20 caracteres.",
        lettersonly: "El nombre solo puede contener letras.",
      },
      lastname_player: {
        required: "Por favor, ingresa tu apellido.",
        minlength: "El apellido debe tener al menos 3 caracteres.",
        maxlength: "El apellido no puede superar los 20 caracteres.",
        lettersonly: "El apellido solo puede contener letras.",
      },
      username: {
        required: "Por favor, ingresa un username.",
        minlength: "El username debe tener al menos 4 caracteres.",
        maxlength: "El username no puede tener más de 20 caracteres.",
        alphanumeric: "El username solo puede contener letras, números y guiones bajos o puntos.",
      },
      email: {
        required: "Por favor, ingresa tu email.",
        email: "Por favor, ingresa un email válido.",
      },
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "div",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      error.insertAfter(element);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass(errorClass).removeClass(validClass);
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass(errorClass).addClass(validClass);
    },
    submitHandler: function (form) {
      var formData = $(form).serialize();
  
      $.ajax({
        type: "POST",
        url: $(form).attr("action"),
        data: formData,
        dataType: "json", 
        success: function (response) {
          if (response.success) {
            $('#dateModal').modal('hide');  // Cierra el modal

            // Redirige a la página de configuración (si lo deseas)
            window.location.href = "../views/settings.php";  // O elimina esta línea si no deseas redirigir.
          } else {
            // Muestra un mensaje de error si la actualización falla
            $('#response-message').html('<div class="alert alert-danger">' + response.message + '</div>');
          }
        },
        error: function () {
          // Muestra un mensaje de error si algo falla en la solicitud AJAX
          $('#response-message').html('<div class="alert alert-danger">Hubo un problema al procesar tu solicitud.</div>');
        }
      });
      return false;
    },
    invalidHandler: function (event, validator) {
      event.preventDefault();
    },
  });

  // Método personalizado para validar que solo contiene letras
  $.validator.addMethod(
    "lettersonly",
    function (value, element) {
      return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value);
    },
    "Este campo solo puede contener letras."
  );

  // Método personalizado para validar que solo contiene caracteres alfanuméricos y algunos símbolos permitidos
  $.validator.addMethod(
    "alphanumeric",
    function (value, element) {
      return this.optional(element) || /^[a-zA-Z0-9._-]+$/.test(value);
    },
    "Este campo solo puede contener letras, números, puntos, guiones bajos y guiones."
  );
});
