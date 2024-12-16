$(document).ready(function () {
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

  togglePasswordVisibility('toggle-password', 'password');

  $("#loginForm").validate({
    rules: {
      input: { required: true, minlength: 4 },
      password: { required: true, minlength: 6 },
    },
    messages: {
      input: { required: "Por favor, ingresa tu email o username.", minlength: "El username debe tener al menos 3 caracteres." },
      password: { required: "Por favor, ingresa tu contraseña.", minlength: "La contraseña debe tener al menos 6 caracteres." },
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "div",
    
    errorPlacement: function (error, element) {
      error.insertAfter(element.parent());

      error.css('color', 'red');
      error.css('font-size', '0.875rem'); 
    },
    highlight: function (element) {
      $(element).css('border-color', 'red');
      $(element).css('background-color', '#ffdddd'); 
    },

    unhighlight: function (element) {
      $(element).css('border-color', 'green');  
      $(element).css('background-color', '#d4edda');

      $(element).siblings('i') 
        .removeClass('fa-times'); 
    },
  });

  $("#loginForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../controllers/login-controller.php",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(response) {
        if (response.success) {
          window.location.href = response.redirect;
        } else {
          $('#error-message')
            .text(response.error)
            .show()
            .css({
              'padding': '10px',
              'background-color': '#dc3545',
              'color': 'white',
              'border-radius': '5px',
              'font-weight': 'bold',
              'text-align': 'center',
              'margin-top': '10px'
            });
        }
      },
      error: function() {
        alert("Hubo un error al procesar la solicitud.");
      }
    });
  });
});
