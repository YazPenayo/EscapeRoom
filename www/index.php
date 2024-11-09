<?php
include('./models/dbConnection.php');
include('./querys/querys.php');

if ($conn === null) {
  die("Error: No se pudo establecer conexión con la base de datos.");
}

$resultado = $conn->query(SQL_GET_ROOMS);

$habitaciones = [];
if ($resultado && $resultado->num_rows > 0) {
  while ($fila = $resultado->fetch_assoc()) {
      $habitaciones[] = $fila;
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="icon" href="assets/img/logo.png" type="image/png">
  <title>EscapeRoom</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
  <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/responsive.css" rel="stylesheet" />
  <style>
    .modal-content {
      background-color: black;
      color: white;
      border-radius: 10px;
      padding: 20px;
      border: 2px solid white;
    }

    .modal-header {
      border-bottom: none;
      text-align: center;
    }

    .modal-title {
      font-size: 24px;
      color: #fff;
    }

    .modal-body h3 {
      font-weight: bold;
      text-align: center;
      text-transform: uppercase;
      margin-bottom: 20px;
    }

    .close {
      color: white;
      font-size: 30px;
      font-weight: bold;
      opacity: 1;
      transition: none;
      border: none;
      background: transparent;
    }

    .close:hover, .close:focus {
      color: white;
      opacity: 1;
      background-color: transparent;
      box-shadow: none; 
      outline: none;
    }


    .btn-warning {
      background-color: #f39c12;
      border: none;
    }

    .btn-danger {
      background-color: #db4437;
    }

    .btn-primary {
      background-color: #4267b2;
    }

    a {
      color: #f39c12;
      text-decoration: none;
    }

    .text-center {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="hero_area">
    <div class="hero_bg_box">
      <div class="bg_img_box">
        <img src="assets/img/black.png" alt="">
      </div>
    </div>
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.php">
            <span>EscapeRoom</span>
          </a>
          <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">
                Iniciar Sesión
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">
                Registrarse
              </a>
            </li>
          </ul>
          </div>
        </nav>
      </div>
    </header>

    <section class="slider_section">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container">
              <div class="row">
                <div class="col-md-6">
                  <div class="detail-box">
                    <h1>ESCAPE ROOM</h1>
                    <p style="font-size: 1.2em; margin-top: 20px;">Sumérgete en una experiencia única con nuestro escape room virtual, donde podrás resolver acertijos y desentrañar misterios desde la comodidad de tu hogar.</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="img-box">
                    <img src="assets/img/logo.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <section class="service_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>NUESTRAS <span>HABITACIONES</span></h2>
        <p>Descubre un mundo de desafíos en cada una de nuestras habitaciones temáticas, diseñadas para poner a prueba tu ingenio y habilidades.<br> ¡Elige la experiencia perfecta y sumérgete en una aventura inolvidable!</p>
      </div>
      <div class="row">
        <?php foreach ($habitaciones as $habitacion): ?>
          <div class="col-md-4">
            <div class="box">
              <div class="img-box">
                <?php 
                  if ($habitacion['name'] == 'Laboratorio de Computación') {
                    echo '<i class="fa fa-desktop fa-5x" aria-hidden="true"></i>';
                  } elseif ($habitacion['name'] == 'Salón de Clases') {
                    echo '<i class="fa fa-university fa-5x" aria-hidden="true"></i>';
                  } elseif ($habitacion['name'] == 'Dirección') {
                    echo '<i class="fa fa-key fa-5x" aria-hidden="true"></i>';
                  } else {
                    echo '<i class="fa fa-bed fa-5x" aria-hidden="true"></i>';
                  }
                ?>
              </div>
              <div class="detail-box">
                <h5><?php echo htmlspecialchars($habitacion['name']); ?></h5>
                <p><?php echo htmlspecialchars($habitacion['description']); ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="footer_section">
    <div class="container">
      <p>&copy; <span id="displayYear"></span> EscapeRoom, todos los derechos reservados.</p>
    </div>
  </section>

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
        <form action="controllers/login-controller.php" method="POST">
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
          <form id="register-player-form" method="POST" action="./controllers/register-controller.php">
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
    </div>
  </div>

  <script type="text/javascript" src="assets/js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.js"></script>
  <script type="text/javascript" src="assets/js/custom.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    $('#registerModal a[data-target="#loginModal"]').on('click', function() {
      $('#registerModal').modal('hide');
      $('#loginModal').modal('show');
    });

    $('#loginModal a[data-target="#registerModal"]').on('click', function() {
      $('#loginModal').modal('hide'); 
      $('#registerModal').modal('show');
    });
  });
</script>

</body>
</html>
