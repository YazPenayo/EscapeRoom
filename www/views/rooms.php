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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="icon" href="../assets/img/logo.png" type="">
  <title> EscapeRoom </title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
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
  </style>
</head>
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
  
  <section class="service_section layout_padding">
    <div class="service_container">
      <div class="container ">
        <div class="heading_container heading_center">
        <h2>NUESTRAS <span>HABITACIONES</span></h2>
        <p>Descubre un mundo de desafíos en cada una de nuestras habitaciones temáticas, diseñadas para poner a prueba tu ingenio y habilidades.<br> ¡Elige la experiencia perfecta y sumérgete en una aventura inolvidable!</p>
        </div>
        <div class="row">
          <?php foreach ($habitaciones as $habitacion): ?>
          <div class="col-md-4 ">
            <div class="box ">
              <div class="img-box">
              <?php 
                  if ($habitacion['room_name'] == 'Laboratorio de Computación') {
                    echo '<i class="fa fa-desktop fa-5x" aria-hidden="true"></i>';
                  } elseif ($habitacion['room_name'] == 'Salón de Clases') {
                    echo '<i class="fa fa-university fa-5x" aria-hidden="true"></i>';
                  } elseif ($habitacion['room_name'] == 'Dirección') {
                    echo '<i class="fa fa-key fa-5x" aria-hidden="true"></i>';
                  } else {
                    echo '<i class="fa fa-bed fa-5x" aria-hidden="true"></i>';
                  }
                ?>
              </div>
              <div class="detail-box">
                <h5><?php echo htmlspecialchars($habitacion['room_name']); ?></h5>
                <p><?php echo htmlspecialchars($habitacion['description']); ?></p>
              
              <?php 
                  if (!isset($_SESSION['id_player'])): 
                    $_SESSION['selected_room'] = $habitacion['id_room'];
                ?>
                   <a href="#" data-toggle="modal" data-target="#loginModal" class="d-block" style="background-color: #ffe100; color: white; border-radius: 30px; padding: 10px 30px; font-size: 16px; font-weight: bold; text-transform: uppercase; border: none; display: inline-block; text-align: center; transition: all 0.3s ease;">
                      INICIAR SESIÓN
                    </a>
                    <?php else: ?>
                      <a href="./trivia.php?id_room=<?php echo $habitacion['id_room']; ?>" class="d-block" style="background-color: #ffe100; color: white; border-radius: 30px; padding: 10px 30px; font-size: 16px; font-weight: bold; text-transform: uppercase; border: none; display: inline-block; text-align: center; transition: all 0.3s ease;">
                        PLAY
                      </a>
                <?php endif; ?>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
    include_once "./modals.php";
  ?>
  <script type="text/javascript" src="../assets/js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="../assets/js/bootstrap.js"></script>
  <script type="text/javascript" src="../assets/js/custom.js"></script>
</body>
</html>