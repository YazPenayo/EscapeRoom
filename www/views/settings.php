<?php
session_start();
include('../models/dbConnection.php');
include('../querys/querys.php');

$resultado = $conn->query(SQL_GET_ROOMS);
$habitaciones = [];
if ($resultado && $resultado->num_rows > 0) {
  while ($fila = $resultado->fetch_assoc()) {
      $habitaciones[] = $fila;
  }
}
// Prepara y ejecuta la consulta para obtener los datos del jugador
$id_player = $_SESSION['id_player'];
$stmt = $conn->prepare(SQL_GET_PLAYER_DATA);
$stmt->bind_param("i", $id_player); // Vincula el parámetro ID del jugador
$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encuentra el jugador
if ($result->num_rows > 0) {
    $player_data = $result->fetch_assoc();
} else {
    // Si no se encuentra el jugador, puedes manejar el error de alguna forma
    echo "Datos del jugador no encontrados.";
    exit();
}
include_once "../assets/includes/header.php";
?>
<body class="sub_page">

<div class="hero_area">
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="../index.php">
            <span>
              EscapeRoom
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
              <?php if (isset($_SESSION['id_player'])): ?>
                <li class="nav-item">
                  <a class="nav-link" href="./settings.php">Ajustes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./logout.php"> Cerrar Sesión</a>
                </li>
              <?php else: ?>
                <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">Registrarse</a>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </nav>
      </div>
    </header>
  </div>
  <section class="why_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>AJUSTES</h2>
    </div>
    <div class="why_container">
      <a class="box" href="#" data-toggle="modal" data-target="#dateModal" style="color: black; text-decoration: none;">
        <div class="img-box">
          <img src="../assets/img/usuario.png" alt="">
        </div>
        <div class="detail-box">
          <h5>Mis datos</h5>
          <p>Aquí podrás ver y actualizar tus datos personales. Asegúrate de tener tu información actualizada para recibir las mejores ofertas y comunicaciones. Si necesitas cambiar tu dirección de correo electrónico o número de teléfono, puedes hacerlo desde esta sección.</p>
        </div>
      </a>
      <a class="box" href="#" data-toggle="modal" data-target="#historyModal" style="color: black; text-decoration: none;">
        <div class="img-box">
          <img src="../assets/img/historia.png" alt="">
        </div>
        <div class="detail-box">
          <h5>Historial</h5>
          <p>En esta sección podrás ver tu historial de actividad, incluyendo compras, reservas anteriores y más. Es una forma rápida de revisar lo que has hecho en el pasado y obtener detalles importantes de tus interacciones con el sistema.</p>
        </div>
      </a>
      <a href="./rooms.php" class="box" style="color: black; text-decoration: none;">
        <div class="img-box">
          <img src="../assets/img/room.png" alt="">
        </div>
        <div class="detail-box">
          <h5>Habitaciones</h5>
          <p>Aquí podrás gestionar tus reservas de habitaciones, revisar las opciones disponibles y ver detalles sobre las comodidades. Si tienes alguna preferencia o solicitud especial para tu estancia, puedes gestionarlo directamente desde esta sección.</p>
        </div>
      </a>
    </div>
  </div>
</section>

<div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: black; color: white; border-radius: 10px; padding: 20px; border: 2px solid white;">
      <div class="modal-header" style="border-bottom: none; text-align: center;">
        <h5 class="modal-title" id="dateModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; font-size: 30px; font-weight: bold; opacity: 1; transition: none; border: none; background: transparent;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: black; color: white;">
        <form id="dates-player-form" method="POST" action="../controllers/mydates-controller.php">
          <h3 style="font-weight: bold; text-align: center; text-transform: uppercase; margin-bottom: 20px;">MIS DATOS</h3>
          <input type="hidden" name="id_player" value="<?php echo htmlspecialchars($player_data['id_player']); ?>">
          <div class="form-group">
            <label for="fname_player">Nombre</label>
            <input type="text" class="form-control" id="name_player" name="name_player" value="<?php echo htmlspecialchars($player_data['name_player']); ?>" required>
          </div>
          <div class="form-group">
            <label for="lastname_player">Apellido</label>
            <input type="text" class="form-control" id="lastname_player" name="lastname_player" value="<?php echo htmlspecialchars($player_data['lastname_player']); ?>" required>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($player_data['username']); ?>" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($player_data['email']); ?>" required>
          </div>
          <br>
          <button type="submit" class="btn btn-warning btn-block" style="background-color: #f39c12; border: none;">Guardar</button>
          <div id="response-message"></div>
          <p class="mt-3 text-center">¿Deseas modificar tu contraseña actual? <a href="#" style="color: #f39c12;" data-toggle="modal" data-target="#contraseñaModal" data-dismiss="modal">Contraseña</a></p>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Cambiar Contraseña -->
<div class="modal fade" id="contraseñaModal" tabindex="-1" aria-labelledby="contraseñaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: black; color: white; border-radius: 10px; padding: 20px; border: 2px solid white;">
      <div class="modal-header" style="border-bottom: none; text-align: center;">
        <h5 class="modal-title" id="contraseñaModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; font-size: 30px; font-weight: bold; opacity: 1; transition: none; border: none; background: transparent;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: black; color: white;">
        <form id="password-player-form" method="POST" action="../controllers/password-controller.php">
          <h3 style="font-weight: bold; text-align: center; text-transform: uppercase; margin-bottom: 20px;">CAMBIAR CONTRASEÑA</h3>
            <div class="form-group">
              <label for="password_last">Contraseña Actual</label>
              <div class="input-group">
                <input type="password" class="form-control" placeholder="Contraseña Actual" id="password_last" name="password_last" required>
                <div class="input-group-append">
                  <span class="input-group-text" id="toggle-password-last">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="password_new">Contraseña Nueva</label>
              <div class="input-group">
                <input type="password" class="form-control" placeholder="Contraseña Nueva" id="password_new" name="password_new" required>
                <div class="input-group-append">
                  <span class="input-group-text" id="toggle-password-new">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="confirm-password">Confirmar Contraseña</label>
              <div class="input-group">
                <input type="password" class="form-control" placeholder="Confirmar Contraseña" id="confirm-password" name="confirm-password" required>
                <div class="input-group-append">
                  <span class="input-group-text" id="toggle-confirm-password">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </span>
                </div>
              </div>
            </div>
          <br>
          <button type="submit" class="btn btn-warning btn-block" style="background-color: #f39c12; border: none;">Guardar</button>
          <div id="response-message"></div>
          <p class="mt-3 text-center">¿Te gustaría actualizar algún otro dato?<a href="#" style="color: #f39c12;" data-toggle="modal" data-target="#dateModal" data-dismiss="modal"> Mis datos</a></p>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: black; color: white; border-radius: 10px; padding: 20px; border: 2px solid white;">
      <div class="modal-header" style="border-bottom: none; text-align: center;">
        <h5 class="modal-title" id="historyModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; font-size: 30px; font-weight: bold; opacity: 1; transition: none; border: none; background: transparent;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: black; color: white;">
        <h3 style="font-weight: bold; text-align: center; text-transform: uppercase; margin-bottom: 20px;">Historial de juego</h3>
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-6"><strong>Usuario:</strong></div>
          <div class="col-6" id="username"><?php echo htmlspecialchars($player_data['username']); ?></div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-6"><strong>Habitaciones Completas:</strong></div>
          <div class="col-6" id="habitacionesColectadas">0</div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-6"><strong>Respuestas Correctas:</strong></div>
          <div class="col-6" id="respuestasCorrectas">0</div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-6"><strong>Respuestas Incorrectas:</strong></div>
          <div class="col-6" id="respuestasIncorrectas">0</div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-6"><strong>Fecha de Registro:</strong></div>
          <div class="col-6" id="fechaRegistro"><?php echo date('d-m-Y', strtotime($player_data['registration_date'])); ?></div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
    include_once "../assets/includes/footer.php";
?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
  // Función para mostrar/ocultar la contraseña actual en el modal de cambiar contraseña
  const togglePasswordLast = document.getElementById('toggle-password-last');
  if (togglePasswordLast) {
    togglePasswordLast.addEventListener('click', function() {
      const passwordField = document.getElementById('password_last');
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

  // Función para mostrar/ocultar la nueva contraseña en el modal de cambiar contraseña
  const togglePasswordNew = document.getElementById('toggle-password-new');
  if (togglePasswordNew) {
    togglePasswordNew.addEventListener('click', function() {
      const passwordField = document.getElementById('password_new');
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

  // Función para mostrar/ocultar la confirmación de la contraseña en el modal de cambiar contraseña
  const toggleConfirmPassword = document.getElementById('toggle-confirm-password');
  if (toggleConfirmPassword) {
    toggleConfirmPassword.addEventListener('click', function() {
      const confirmPasswordField = document.getElementById('confirm-password');
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
});

</script>
</body>