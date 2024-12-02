<?php
session_start();

if (!isset($_SESSION['id_player'])) {
    // Si no está logueado, redirigir a la página de inicio (login)
    header("Location: ../index.php");
    exit();
}
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
include('../models/dbConnection.php');
include('../querys/querys.php');

if (isset($_GET['id_room'])) {
    $_SESSION['selected_room'] = $_GET['id_room'];
}

$mensaje = "";
$respuesta_correcta = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {

  $selected_answer = $_POST['answer'];
  if ($stmt = $conn->prepare(SQL_GET_CORRECT_ANSWER)) {
      $stmt->bind_param("i", $_SESSION['selected_room']);
      $stmt->execute();
      $resultado = $stmt->get_result();

      if ($resultado && $resultado->num_rows > 0) {
          $correct_answer = $resultado->fetch_assoc();

          if ($selected_answer == $correct_answer['id_question_option']) {
              $mensaje = "¡Correcta!";
              $respuesta_correcta = true;
          } else {
              $mensaje = "Incorrecta";
          }
      } 
      $stmt->close();
  }
}

if (isset($_SESSION['selected_room'])) {
    if ($stmt = $conn->prepare(SQL_GET_QUESTIONS)) {
        $stmt->bind_param("i", $_SESSION['selected_room']);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado && $resultado->num_rows > 0) {
            $pregunta = $resultado->fetch_assoc();
            $pregunta_texto = $pregunta['question'];
        }
        $stmt->close();
    }

    if ($stmt = $conn->prepare(SQL_GET_QUESTION_OPTIONS)) {
      $stmt->bind_param("i", $_SESSION['selected_room']);
      $stmt->execute();
      $resultado = $stmt->get_result();
      
      while ($row = $resultado->fetch_assoc()) {
          $options[] = $row;
      }
      $stmt->close();
  }
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

    <section class="service_section layout_padding">
        <div class="service_container">
            <div class="container">
                <div class="trivia-section">
                    <div class="heading_container heading_center">
                        <h2>ESCAPE<span>ROOM</span></h2>
                    </div>
                    <div class="trivia-content">
                        <div class="trivia-question"><?php echo htmlspecialchars($pregunta_texto); ?></div>
                        <form method="POST" action="">
                          <div class="trivia-options">
                              <?php foreach ($options as $option): ?>
                                  <input type="radio" name="answer" value="<?php echo $option['id_question_option']; ?>" id="option-<?php echo $option['id_question_option']; ?>">
                                  <label for="option-<?php echo $option['id_question_option']; ?>"><?php echo $option['option_text']; ?></label>
                              <?php endforeach; ?>
                          </div>
                          <button type="submit" class="btn-submit">ENVIAR</button>
                      </form>
                        <?php if ($mensaje): ?>
                            <div class="alert <?php echo $respuesta_correcta ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="timer" id="timer">00:00</div>
                <div class="btn-help" id="btn-help"><a href=""><img src="../assets/img/boton-rojo.png" alt="" style="width:45px; height:45px"></a></div>
            </div>
        </div>
    </section>

    <?php
            include_once "../assets/includes/footer.php";
            include_once "./modals.php";
    ?>
</body>
</html>
