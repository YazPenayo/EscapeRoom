<?php

include('./models/dbConnection.php');
include('./querys/querys.php');

// Verificar si la conexión se realizó correctamente
if ($conn === null) {
  die("Error: No se pudo establecer conexión con la base de datos.");
}

// Ejecutar la consulta usando la conexión existente
$resultado = $conn->query(SQL_GET_ROOMS);

// Verificar si hay resultados y almacenar las habitaciones
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
  <link rel="
  
  
  icon" href="assets/img/logo.png" type="">
  <title> EscapeRoom </title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
  <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/responsive.css" rel="stylesheet" />
</head>
<body>
  <div class="hero_area">
    <div class="hero_bg_box">
      <div class="bg_img_box">
        <img src="assets/img/black.png" alt="">
      </div>
    </div>
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <span>
              EscapeRoom
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
              <li class="nav-item">
                <a class="nav-link" href="views/login.php">Iniciar Sesión</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="views/register.php">Registrate</a>
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
                  }else {
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
      <p>
        &copy; <span id="displayYear"></span> EscapeRoom, todos los derechos reservados.
      </p>
    </div>
  </section>
  <script type="text/javascript" src="assets/js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.js"></script>
  <script type="text/javascript" src="assets/js/custom.js"></script>
  
</body>
</html>


