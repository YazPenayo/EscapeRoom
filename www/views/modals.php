
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
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
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
              <label for="password">Contraseña</label>
              <input type="password" class="form-control" placeholder="Contraseña" id="password" name="password" required>
            </div>
            <div class="form-group">
              <label for="confirm-password">Confirmar Contraseña</label>
              <input type="password" class="form-control" placeholder="Confirmar Contraseña" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit" class="btn btn-warning btn-block">Registrarte</button>
            <div id="response-message"></div>
            <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="#" style="color: #f39c12;" data-toggle="modal" data-target="#loginModal" data-dismiss="modal">Inicia sesión</a></p>
          </form>
        </div>
      </div>