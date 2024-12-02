<?php
include('./models/dbConnection.php');
include('./querys/querys.php');

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
            <li class="nav-item">
              <a class="nav-link" href="views/rooms.php">
                Habitaciones
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

    </div>
  </div>
  <?php
    include_once "./views/modals.php";
  ?>
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
