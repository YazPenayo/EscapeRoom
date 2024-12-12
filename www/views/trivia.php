<?php
session_start();
if (!isset($_SESSION['id_player'])) {
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
$options = [];
$total_answer = 0;
if (isset($_SESSION['selected_room'])) {
    if ($stmt = $conn->prepare(SQL_GET_RANDOM_UNANSWERED_QUESTIONS)) {
        $stmt->bind_param('iii', $_SESSION['id_player'], $_SESSION['selected_room'], $_SESSION['id_player']);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado && $resultado->num_rows > 0) {
            $pregunta = $resultado->fetch_assoc();
            $pregunta_texto = $pregunta['question'];
            $id_question = $pregunta['id_question'];

            if (isset($pregunta['id_question'])) {
                $_SESSION['id_question'] = $pregunta['id_question'];
            }
            if ($stmt_options = $conn->prepare(SQL_GET_RANDOM_QUESTION_OPTIONS)) {
                $stmt_options->bind_param('i', $id_question);
                $stmt_options->execute();
                $resultado_options = $stmt_options->get_result();
                
                while ($row = $resultado_options->fetch_assoc()) {
                    $options[] = $row;
                }
                $stmt_options->close();
            }
        } else {
            $total_answer = 8;
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
                        <span>EscapeRoom</span>
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
                    <div class="trivia-header">
                        <div id="timer" class="timer">00:00</div>
                        <button id="help-button" class="btn-exit" data-toggle="modal" data-target="#confirmHintModal">
                            <img src="../assets/img/boton-rojo.png" alt="" style="width:55px; height:55px">
                        </button>
                    </div>
                    <div class="heading_container heading_center">
                        <h2>ESCAPE<span>ROOM</span></h2>
                    </div>
                    <div class="trivia-content">
                        <div class="trivia-question" id="question-text"><?php echo htmlspecialchars($pregunta_texto); ?></div>
                        <form method="POST" id="trivia-form">
                            <div class="trivia-options" id="options-container">
                                <?php if ($total_answer != 8): ?>
                                    <?php if (!empty($options)): ?>
                                        <?php foreach ($options as $option): ?>
                                            <div class="option-container">
                                                <input type="radio" name="selected_option" value="<?php echo $option['id_question_option']; ?>" id="option-<?php echo $option['id_question_option']; ?>">
                                                <label for="option-<?php echo $option['id_question_option']; ?>">
                                                    <?php echo htmlspecialchars($option['option_text'], ENT_QUOTES, 'UTF-8'); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn-submit">ENVIAR</button>
                                <?php else: ?>
                                    <div class="modal-body" style="color: white; padding: 20px; border-radius: 10px; text-align: center; border: 2px solid white;">
                                        <h3 style="font-weight: bold; text-transform: uppercase; margin-bottom: 20px;">Habitación Completa</h3>
                                        <p style="margin-bottom: 20px; font-size: 16px;">¡Has respondido todas las preguntas correctamente!</p>
                                        <p style="font-size: 18px; font-weight: bold; margin-top: 10px;">8/8 Respuestas Conseguidas</p>
                                    </div>
                                <?php endif; ?>
                            </form>
                            <br>          
                            <div id="response-message"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php
        include_once "../assets/includes/footer.php";
        include_once "./modals.php";
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const btnEnviar = document.querySelector('.btn-submit');
        const triviaOptions = document.querySelectorAll('.trivia-options input');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); 
                
                let selectedOption = null;
                triviaOptions.forEach(option => {
                    if (option.checked) {
                        selectedOption = option.value;
                    }
                });

                if (selectedOption) {
                    const data = new FormData();
                    data.append('selected_option', selectedOption);
                    data.append('question_id', '<?php echo $id_question; ?>');
                    
                    fetch('../controllers/validate-answer-controller.php', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(data => {
                        const messageContainer = document.querySelector('#response-message');
                        messageContainer.innerHTML = '';

                        if (data.correct) {
                            messageContainer.innerHTML = '<div class="alert alert-success" role="alert" style="background-color: #28a745; color: white; border: 1px solid #218838; padding: 10px; border-radius: 5px;"> RESPUESTA CORRECTA</div>';
                        } else {
                            messageContainer.innerHTML = '<div class="alert alert-danger" role="alert" style="background-color: #dc3545; color: white; border: 1px solid #c82333; padding: 10px; border-radius: 5px;">RESPUESTA INCORRECTA</div>';
                        }

                        if (data.correct) {
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        });
    </script>
    <script>
    $(document).ready(function () {
    const confirmHintModal = $('#confirmHintModal');
    const hintModal = $('#hintModal');
    const hintText = $('#hint');
    const errorMessage = $('#error-message');
    const confirmYesButton = $('#confirm-yes');

    let idQuestion = parseInt("<?php echo $_SESSION['id_question']; ?>");
    let idPlayer = parseInt("<?php echo $_SESSION['id_player']; ?>");
    let idRoom = parseInt("<?php echo $_SESSION['selected_room']; ?>");

    $('#help-button').on('click', function () {
        console.log('Botón de ayuda clicado, abriendo modal de confirmación...');
        confirmHintModal.modal('show');
    });
    confirmYesButton.on('click', function () {
        console.log('Confirmación de uso de pista, enviando solicitud AJAX...');
        console.log('ID de la pregunta enviada:', idQuestion);
        $.ajax({
            url: '../controllers/hint-controller.php',
            type: 'POST',
            data: { id_question: idQuestion, id_player: idPlayer, id_room: idRoom },
            dataType: 'json',
            success: function (response) {
                console.log('Respuesta del servidor recibida:', response);

                if (response.success) {
                    $('#hint-title').text('TU PISTA');
                    hintText.text(response.hint); 
                    errorMessage.hide(); 
                    $('#hint-container').show(); 
                } else {
                    $('#hint-title').text('PISTA AGOTADA');
                    hintText.text(''); 
                    $('#hint-container').hide();
                    errorMessage
                        .text(response.error)
                        .css({
                            display: 'block',
                            color: 'white',
                            border: '1px solid white',
                            padding: '10px',
                            'border-radius': '5px',
                            'background-color': 'transparent',
                            'text-align': 'center',
                        });
                }
                confirmHintModal.modal('hide');
                hintModal.modal('show');
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX:', status, error);
                errorMessage
                    .text('Error al intentar obtener la pista.')
                    .css({
                        display: 'block',
                        color: 'white',
                        border: '1px solid white',
                        padding: '10px',
                        'border-radius': '5px',
                        'background-color': 'transparent',
                        'text-align': 'center',
                    });
                hintText.text('');
                $('#hint-container').hide();
                hintModal.modal('show');
            },
        });
    });
    $('#hintModal .btn-warning').on('click', function () {
        console.log('Modal de pista cerrado por el usuario.');
        hintModal.modal('hide');
    });
});

</script>

<script>
    $('#trivia-form').on('submit', function(e) {
    e.preventDefault();

    const selectedOption = $('input[name="selected_option"]:checked').val();
    const idQuestion = <?php echo $_SESSION['id_question']; ?>;
    const correct =  1;

    $.ajax({
        url: '../controllers/progress-controller.php',
        type: 'POST',
        data: { id_question: idQuestion, correct: correct },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log('Progreso registrado correctamente.');
            } else {
                alert(response.error || 'Error al registrar el progreso.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', status, error);
        }
    });
});

</script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let timerElement = document.getElementById('timer');
        let totalTime = 60;

        function startTimer() {
            let timerInterval = setInterval(function() {
                let minutes = Math.floor(totalTime / 60);
                let seconds = totalTime % 60;

                timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (totalTime <= 0) {
                    clearInterval(timerInterval);
                    showTimeUpModal();
                } else {
                    totalTime--;
                }
            }, 1000);
        }

        function showTimeUpModal() {
            $('#timeUpModal').modal('show');
        }

        document.getElementById('continueButton').addEventListener('click', function() {
      $('#timeUpModal').modal('hide');
            totalTime = 30; 
            startTimer();
        });

        // Botón "Abandonar"
        document.getElementById('quitButton').addEventListener('click', function() {
            window.location.href = './rooms.php';
        });
        startTimer();
    });
</script>
</body>
</html>
