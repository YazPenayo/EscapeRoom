<?php

include('../models/dbConnection.php');
include('../querys/querys.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EscapeRoom - Registro de Jugador</title>
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form id="register-player-form" method="POST" action="../controllers/register-controller.php">
        <h3>Crea una nueva cuenta</h3>
        <div class="form-row">
            <div class="form-column">
                <label for="first-name">Nombre</label>
                <input type="text" placeholder="Nombre" id="fname_player" name="name_player" required>
                
                <label for="last-name">Apellido</label>
                <input type="text" placeholder="Apellido" id="lastname_player" name="lastname_player" required>
                
                <label for="username">Username</label>
                <input type="text" placeholder="Username" id="username" name="username" required>
            </div>
            <div class="form-column">
                <label for="email">Email</label>
                <input type="email" placeholder="Email" id="email" name="email" required>
                
                <label for="password">Contraseña</label>
                <input type="password" placeholder="Contraseña" id="password" name="password" required>
                
                <label for="confirm-password">Confirmar Contraseña</label>
                <input type="password" placeholder="Contraseña" id="confirm-password" name="confirm-password" required>
            </div>
        </div>
        <button type="submit">Registrarte</button>
        <div id="response-message"></div>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>
    <script src="../assets/js/main.js"></script>
    <script>
        $(document).ready(function () {
            $("#register-player-form").on("submit", function (event) {
                const password = $("#password").val();
                const confirmPassword = $("#confirm-password").val();

                // Verificar si las contraseñas coinciden
                if (password !== confirmPassword) {
                    event.preventDefault(); // Evitar envío del formulario
                    $("#response-message").html("<p style='color: red; font-family: 'Poppins', sans-serif;font-size: 20px;'>Las contraseñas no coinciden. Por favor, inténtalo de nuevo.</p>");
                } else {
                    $("#response-message").html("");
                }
            });
        });
    </script>
</body>
</html>

