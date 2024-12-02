

<!-- Modal de Inicio de Sesión -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: black; color: white;">
        <form action="../controllers/login-controller.php" method="POST">
          <h3>Iniciar Sesión</h3>
          <div class="form-group">
            <label for="input">Username</label>
            <input type="text" class="form-control" id="input" name="input" placeholder="Email o Username" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
              <div class="input-group-append">
                <span class="input-group-text" id="toggle-password">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-warning btn-block">Iniciar Sesión</button>
        </form>
        <p class="mt-3 text-center">¿No tienes cuenta? <a href="#" style="color: #f39c12;" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">Regístrate</a></p>
      </div>
    </div>
  </div>
</div>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>
<!-- Modal de Registro -->
<!-- Modal de Registro -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: black; color: white;">
        <form id="register-player-form" method="POST" action="../controllers/register-controller.php">
          <h3>Registrarse</h3>
          <div class="form-group">
            <label for="fname_player">Nombre</label>
            <input type="text" class="form-control" placeholder="Nombre" id="fname_player" name="name_player" required>
          </div>
          <div class="form-group">
            <label for="lastname_player">Apellido</label>
            <input type="text" class="form-control" placeholder="Apellido" id="lastname_player" name="lastname_player" required>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="password-register">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Contraseña" id="password-register" name="password" required>
              <div class="input-group-append">
                <span class="input-group-text" id="toggle-password-register">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="confirm-password-register">Confirmar Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Confirmar Contraseña" id="confirm-password-register" name="confirm-password" required>
              <div class="input-group-append">
                <span class="input-group-text" id="toggle-confirm-password-register">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-warning btn-block">Registrarte</button>
          <div id="response-message"></div>
          <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="#" style="color: #f39c12;" data-toggle="modal" data-target="#loginModal" data-dismiss="modal">Inicia sesión</a></p>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
  // Función para mostrar/ocultar la contraseña en el formulario de registro
  const togglePasswordRegister = document.getElementById('toggle-password-register');
  if (togglePasswordRegister) {
    togglePasswordRegister.addEventListener('click', function() {
      const passwordField = document.getElementById('password-register');
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

  // Función para mostrar/ocultar la confirmación de la contraseña en el formulario de registro
  const toggleConfirmPasswordRegister = document.getElementById('toggle-confirm-password-register');
  if (toggleConfirmPasswordRegister) {
    toggleConfirmPasswordRegister.addEventListener('click', function() {
      const confirmPasswordField = document.getElementById('confirm-password-register');
      const icon = this.querySelector('i');
      if (confirmPasswordField.type === 'password') {
        confirmPasswordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        confirmPasswordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });
  }

  // Función para mostrar/ocultar la contraseña en el inicio de sesión (opcional)
  const togglePasswordLogin = document.getElementById('toggle-password');
  if (togglePasswordLogin) {
    togglePasswordLogin.addEventListener('click', function() {
      const passwordField = document.getElementById('password');
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
});
</script>

