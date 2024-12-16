document.addEventListener('DOMContentLoaded', function () {
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

  togglePasswordVisibility('toggle-password-last', 'password_last');
  togglePasswordVisibility('toggle-password-new', 'password_new');
  togglePasswordVisibility('toggle-confirm-password', 'confirm-password');
});
$(document).ready(function () {
  $("#password-player-form").validate({
    rules: {
      password_last: {
        required: true
      },
      password_new: {
        required: true,
        minlength: 6
      },
      "confirm-password": {
        required: true,
        minlength: 6,
        equalTo: "#password_new"
      }
    },
    messages: {
      password_last: {
        required: "Por favor ingresa tu contraseña actual"
      },
      password_new: {
        required: "Por favor ingresa una nueva contraseña",
        minlength: "La contraseña debe tener al menos 6 caracteres"
      },
      "confirm-password": {
        required: "Por favor confirma tu nueva contraseña",
        minlength: "La contraseña debe tener al menos 6 caracteres",
        equalTo: "Las contraseñas no coinciden"
      }
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "div",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      error.insertAfter(element);

      error.css({
        'display': 'block',
        'position': 'absolute',
        'top': '100%',
        'left': '0',
        'width': '100%',
        'color': 'red',
        'font-size': '0.875rem',
        'margin-top': '-2px' 
      });

      $(element).css('margin-bottom', '5px'); 
      $(element).siblings('.input-group-append').find('span').css({
        'font-size': '1.25rem', 
        'height': $(element).outerHeight() + 'px', 
        'line-height': $(element).outerHeight() + 'px'
      });
    },
    highlight: function (element, errorClass, validClass) {
      $(element).css({
        'border-color': 'red',
        'background-color': '#ffdddd'
      }); 
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).css({
        'border-color': 'green',
        'background-color': '#d4edda'
      });

      $(element).siblings('.invalid-feedback').hide();
    },
    submitHandler: function (form) {
      var formData = $(form).serialize();
      $.ajax({
        type: "POST",
        url: $(form).attr("action"),
        data: formData,
        dataType: "json", 
        success: function (response) {
          $('#contraseñaModal').modal('hide');
          window.location.href = "../views/settings.php";
        }
      });
      return false;
    },
    invalidHandler: function (event, validator) {
      event.preventDefault();
    }
  });
});

