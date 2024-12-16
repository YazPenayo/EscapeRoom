$(document).ready(function () {
  // Función para mostrar/ocultar la contraseña
  function togglePasswordVisibility(toggleId, passwordFieldId) {
    const toggleButton = document.getElementById(toggleId);
    if (toggleButton) {
      toggleButton.addEventListener('click', function() {
        const passwordField = document.getElementById(passwordFieldId);
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
          passwordField.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          passwordField.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    }
  }

  // Aplicando la función a los campos del formulario de registro
  togglePasswordVisibility('toggle-password-register', 'password-register');
  togglePasswordVisibility('toggle-confirm-password-register', 'confirm-password-register');

  // Validación para el formulario de registro
  $("#register-player-form").validate({
    rules: {
      name_player: {
        required: true,
        minlength: 3,
        maxlength: 20,
        lettersonly: true, // Solo letras
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
        alphanumeric: true, // Letras, números, guiones bajos o puntos
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 6,
      },
      "confirm-password": {
        required: true,
        equalTo: "#password-register", // Igual al campo de contraseña
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
      password: {
        required: "Por favor, ingresa una contraseña.",
        minlength: "La contraseña debe tener al menos 6 caracteres.",
      },
      "confirm-password": {
        required: "Por favor, confirma tu contraseña.",
        equalTo: "Las contraseñas no coinciden.",
      },
    },
    errorClass: "is-invalid",   // No cambiaremos esto, pero evitamos agregar la X con los siguientes métodos
    validClass: "is-valid",
    errorElement: "div",       // Asegúrate de que el mensaje de error sea un div
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      error.insertAfter(element); // El mensaje de error se muestra debajo del input
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass(errorClass).removeClass(validClass);
      // Estilo para el campo con error: borde rojo y fondo rojo claro
      $(element).css('border-color', 'red');
      $(element).css('background-color', '#ffdddd');
      // Eliminar la "X" si existe
      $(element).siblings('i').remove(); // Eliminar el ícono si está presente
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass(errorClass).addClass(validClass);
      // Restaurar el borde y fondo cuando es válido
      $(element).css('border-color', 'green');
      $(element).css('background-color', '#d4edda');
    },
    submitHandler: function (form) {
      var formData = $(form).serialize(); // Serializa el formulario para enviarlo

      $.ajax({
        type: "POST",
        url: $(form).attr("action"),
        data: formData,
        dataType: "json",
        success: function (response) {
          if (response.error_username) {
            $('#response-message').html('<div class="alert alert-danger">' + response.error_username + '</div>');
            $('#errorModal').modal('show');
          } else if (response.error_email) {
            $('#response-message').html('<div class="alert alert-danger">' + response.error_email + '</div>');
            $('#errorModal').modal('show');
          } else if (response.success) {
            // Cerrar el modal y redirigir si la respuesta es exitosa
            $('#registerModal').modal('hide'); // Cerrar modal
            $('body').removeClass('modal-open'); // Eliminar fondo del modal
            $('.modal-backdrop').remove();
            window.location.href = "../../../index.php"; // Redirigir a index.php
          }
        },
        error: function (xhr, status, error) {
          // Manejo de errores de la solicitud AJAX
          console.log("Error en la solicitud AJAX: " + error);
        }
      });
      return false;
    },
    invalidHandler: function (event, validator) {
      event.preventDefault();
    },
  });

  // Métodos personalizados para validación
  $.validator.addMethod("lettersonly", function (value, element) {
    return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value);
  }, "Este campo solo puede contener letras.");

  $.validator.addMethod("alphanumeric", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._-]+$/.test(value);
  }, "Este campo solo puede contener letras, números, puntos, guiones bajos y guiones.");
});