<!-- MODAL DE LOGIN -->
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
        <form id="loginForm" action="../controllers/login-controller.php" method="POST">
          <h3>Iniciar Sesión</h3>
          <div class="form-group">
            <label for="input">Username</label>
            <input type="text" class="form-control" id="input" name="input" placeholder="Email o Username" />
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" />
              <div class="input-group-append">
                <span class="input-group-text" id="toggle-password">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-warning btn-block">Iniciar Sesión</button>
          <div id="error-message" class="mt-3 text-center" style="display: none;"></div>
        </form>
        <p class="mt-3 text-center">
          ¿No tienes cuenta?
          <a href="#" style="color: #f39c12;" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">Regístrate</a>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DE REGISTRO -->
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
            <label for="name_player">Nombre</label>
            <input type="text" class="form-control" placeholder="Nombre" id="name_player" name="name_player">
          </div>
          <div class="form-group">
            <label for="lastname_player">Apellido</label>
            <input type="text" class="form-control" placeholder="Apellido" id="lastname_player" name="lastname_player">
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" placeholder="Username" id="username" name="username">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" placeholder="Email" id="email" name="email">
          </div>
          <div class="form-group">
            <label for="password-register">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Contraseña" id="password-register" name="password">
            </div>
          </div>
          <div class="form-group">
            <label for="confirm-password-register">Confirmar Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Confirmar Contraseña" id="confirm-password-register" name="confirm-password">
            </div>
          </div>
          <button type="submit" class="btn btn-warning btn-block">Registrarte</button>
          <br>
          <div id="response-message"></div>
          <p class="mt-3 text-center">¿Ya tienes cuenta? 
            <a href="#" style="color: #f39c12;" data-toggle="modal" data-target="#loginModal" data-dismiss="modal">Inicia sesión</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- MODAL DE CONFIRMACIÓN -->
<div class="modal fade" id="confirmHintModal" tabindex="-1" aria-labelledby="confirmHintModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: black; color: white; border-radius: 10px; padding: 20px; border: 2px solid white;">
      <div class="modal-header" style="border-bottom: none; text-align: center; background-color: black; color: white;">
        <h5 class="modal-title" id="confirmHintModalLabel" style="color: white;"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; font-size: 30px; font-weight: bold; opacity: 1; transition: none; border: none; background: transparent;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: black; color: white; padding-top: 0;">
        <h3 style="font-weight: bold; text-align: center; text-transform: uppercase; margin-bottom: 20px;">AYUDA</h3>
        <p id="hint-text" style="text-align: center; margin-bottom: 20px;">Estás a punto de usar la pista. <br>Solo puedes hacerlo una vez por habitación.<br>¿Estás seguro?</p>
      </div>
      <div class="modal-footer" style="border-top: none; text-align: center;">
        <button type="button" class="btn btn-warning" id="confirm-yes" style="background-color: #f39c12; border: none; padding: 8px 16px; border-radius: 5px; color: white; font-weight: bold; font-size: 14px;">USAR</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal" style="background-color: white; border: 2px solid #f39c12; padding: 8px 16px; color: #f39c12; font-weight: bold; font-size: 14px;">CERRAR</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL DE PISTA -->
<div class="modal fade" id="hintModal" tabindex="-1" aria-labelledby="hintModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: black; color: white; border-radius: 10px; padding: 20px; border: 2px solid white;">
      <div class="modal-header" style="background-color: black; color: white; border-bottom: none;">
        <h5 class="modal-title" id="hintModalLabel" style="color: white; display: none;"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; font-size: 30px; font-weight: bold; opacity: 1; border: none; background: transparent;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: black; color: white; padding-top: 0;">
        <h3 id="hint-title" style="font-weight: bold; text-align: center; text-transform: uppercase; margin-bottom: 20px;"></h3>
        <!-- Contenedor de la pista -->
        <div id="hint-container" style="display: none; border: 1px solid white; padding: 10px; border-radius: 5px; background: transparent; text-align: center;">
          <p id="hint" style="margin-bottom: 20px;"></p>
        </div>
        <!-- Contenedor del mensaje de error -->
        <p id="error-message" style="display: none; text-align: center; color: white; border: 1px solid white; padding: 10px; border-radius: 5px; background-color: transparent;"></p>
      </div>
      <div class="modal-footer" style="border-top: none;">
        <button type="button" class="btn btn-warning btn-block" style="background-color: #f39c12; border: none;" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL TIMER -->
<div class="modal fade" id="timeUpModal" tabindex="-1" role="dialog" aria-labelledby="timeUpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: black; color: white; border-radius: 10px; padding: 20px; border: 2px solid white;">
            <div class="modal-header" style="border-bottom: none; display: flex; justify-content: center; align-items: center;">
                <h5 class="modal-title" id="timeUpModalLabel" style="font-size: 24px; color: #fff; font-weight: bold;">TIEMPO AGOTADO</h5>
            </div>
            <div class="modal-body" style="font-weight: bold; text-align: center; text-transform: none; margin-bottom: 20px;">
                El tiempo se ha agotado. ¿Qué deseas hacer?
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <button type="button" class="btn btn-primary" id="continueButton" 
                style="background-color: #f39c12; border: none; padding: 8px 16px; border-radius: 5px; color: white; font-weight: bold; font-size: 14px;">SEGUIR JUGANDO</button>
                <button type="button" class="btn btn-danger" id="quitButton" 
                style="background-color: white; border: 2px solid #f39c12; padding: 8px 16px; color: #f39c12; font-weight: bold; font-size: 14px;">ABANDONAR</button>
            </div>
        </div>
    </div>
</div>